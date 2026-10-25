<?php

namespace App\Http\Controllers\Privates;

use App\Banner;
use App\Http\Controllers\Controller;
use App\Library\Helpers\SeasonHelpers;
use App\Library\NewsLetter\NewsLetter;
use App\Library\StripePayment;
use App\Mail\Privates\PrivateLessonSignUp;
use App\PoolSession;
use App\PrivateLesson;
use App\PrivateSwimmer;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\CardException;
use Stripe\PaymentIntent;

class CalendarController extends Controller
{
    public function __construct(private StripePayment $stripePayment) {}

    public function index()
    {
        $private_pool_sessions = PoolSession::with(['instructor:id,name,hex_color', 'location:id,name'])->privateLessonsAvailable()->startConditionallyNextMonth()->get();
        $banner = Banner::where('page', '/private-semi-private')->first();

        return view('lessons.private.calendar', ['events' => $private_pool_sessions, 'banner' => $banner]);
    }

    public function store(Request $request): RedirectResponse
    {
        $registration = $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'birth_date' => 'required|date|before:today',
            'email' => 'required|string|email|max:191',
            'phone' => 'required|max:20',
            'parent' => 'nullable|max:191',
            'street' => 'required|max:191',
            'city' => 'required|max:191',
            'state' => 'required|max:191',
            'zip' => 'required|max:15',
            'emergency_name' => 'required|max:191',
            'emergency_relationship' => 'required|max:191',
            'emergency_phone' => 'required|max:20',
            'pool_session_ids' => 'required',
            'email_updates' => 'nullable|string',
            'payment_method' => 'required|string',
        ]);

        $poolSessionIds = array_values(array_unique(array_filter(explode(',', $registration['pool_session_ids']))));

        $availablePoolSessions = PoolSession::privateLessonsAvailable()->whereIn('id', $poolSessionIds)->get();

        if (empty($poolSessionIds) || $availablePoolSessions->count() !== count($poolSessionIds)) {
            Log::error('One of the pool session ids '.implode(',', $poolSessionIds).' has already been taken. Redirecting back.');
            session()->flash('warning', 'Sorry, one of the classes was already taken.');

            return redirect(route('private_lesson.index'));
        }

        // Pool sessions without a price cost $35
        $price = $availablePoolSessions->sum(fn (PoolSession $poolSession) => $poolSession->price ?? 35);

        try {
            $paymentIntent = $this->stripePayment->charge(
                $registration['payment_method'],
                $price,
                $registration['email'],
                'Private swim lessons for '.$registration['first_name'].' '.$registration['last_name'].' through The Swim School.',
                route('private_lesson.payment-complete'),
            );
        } catch (CardException $exception) {
            Log::warning('Private lesson payment declined: '.$exception->getMessage());
            session()->flash('error', 'Oops, something went wrong with the payment. '.$exception->getMessage());

            return back()->withInput();
        } catch (\Exception $exception) {
            Log::error('Private lesson payment error: '.$exception->getMessage());
            session()->flash('error', 'Oops, something went wrong with the payment. Please try again or call us.');

            return back()->withInput();
        }

        if (StripePayment::requiresRedirect($paymentIntent)) {
            session()->put("private_lesson_payments.{$paymentIntent->id}", [
                'registration' => $registration,
                'pool_session_ids' => $poolSessionIds,
                'price' => $price,
            ]);

            return redirect()->away(StripePayment::redirectUrl($paymentIntent));
        }

        return $this->completeRegistration($registration, $poolSessionIds, $paymentIntent);
    }

    /**
     * Stripe redirects here after the customer finishes 3D Secure.
     */
    public function paymentComplete(Request $request): RedirectResponse
    {
        $paymentIntentId = (string) $request->query('payment_intent');
        $pendingPayment = session()->pull("private_lesson_payments.{$paymentIntentId}");

        if (! $pendingPayment) {
            if ($paymentIntentId && PrivateSwimmer::where('stripe_charge_id', $paymentIntentId)->exists()) {
                return redirect()->route('pages.thank-you');
            }

            Log::error("No pending private lesson sign up found for payment intent: {$paymentIntentId}");
            session()->flash('warning', 'Something went wrong with your registration. Please call us and we will get you signed up.');

            return redirect()->route('private_lesson.index');
        }

        $paymentIntent = $this->stripePayment->retrieve($paymentIntentId);

        if (! StripePayment::isPaid($paymentIntent, $pendingPayment['price'])) {
            Log::warning("Private lesson payment {$paymentIntentId} was not completed. Status: {$paymentIntent->status}");
            session()->flash('error', 'Oops, something went wrong with the payment. Your card was not charged, please try again.');

            return redirect()->route('private_lesson.index');
        }

        return $this->completeRegistration($pendingPayment['registration'], $pendingPayment['pool_session_ids'], $paymentIntent);
    }

    /**
     * @param  array<string, mixed>  $registration  Validated sign up data
     * @param  array<int, string>  $poolSessionIds
     */
    private function completeRegistration(array $registration, array $poolSessionIds, PaymentIntent $paymentIntent): RedirectResponse
    {
        $privateSwimmer = DB::transaction(function () use ($registration, $poolSessionIds, $paymentIntent) {
            $poolSessions = PoolSession::privateLessonsAvailable()->whereIn('id', $poolSessionIds)->lockForUpdate()->get();

            // Someone else may have taken a session while this customer was paying
            if ($poolSessions->count() !== count($poolSessionIds)) {
                return null;
            }

            $privateLesson = PrivateLesson::create([
                'season_id' => SeasonHelpers::currentSeason()->id,
            ]);

            $privateSwimmer = PrivateSwimmer::create([
                'first_name' => $registration['first_name'],
                'last_name' => $registration['last_name'],
                'birth_date' => Carbon::parse($registration['birth_date']),
                'email' => $registration['email'],
                'phone' => $registration['phone'],
                'parent' => $registration['parent'] ?? null,
                'notes' => null,
                'street' => $registration['street'],
                'city' => $registration['city'],
                'state' => $registration['state'],
                'zip' => $registration['zip'],
                'emergency_name' => $registration['emergency_name'],
                'emergency_relationship' => $registration['emergency_relationship'],
                'emergency_phone' => $registration['emergency_phone'],
                'stripe_charge_id' => $paymentIntent->id,
                'private_lesson_id' => $privateLesson->id,
            ]);

            foreach ($poolSessions as $poolSession) {
                $poolSession->pool_session_id = $privateLesson->id;
                $poolSession->pool_session_type = PrivateLesson::class;
                $poolSession->save();
            }

            return $privateSwimmer;
        });

        if (! $privateSwimmer) {
            Log::warning('One of the pool session ids '.implode(',', $poolSessionIds)." was taken during payment. Refunding payment intent: {$paymentIntent->id}");
            $this->stripePayment->refund($paymentIntent);
            session()->flash('warning', 'Sorry, one of the classes was already taken. Your payment has been refunded.');

            return redirect()->route('private_lesson.index');
        }

        if (($registration['email_updates'] ?? null) == 'on') {
            NewsLetter::subscribe($registration['email']);
        }

        try {
            Mail::to($privateSwimmer->email)->send(new PrivateLessonSignUp($privateSwimmer->lesson));
            Log::info("Sending private lesson sign up email to $privateSwimmer->email");
        } catch (\Exception $e) {
            Log::error("Error trying to send private lesson sign up email to $privateSwimmer->email. Error:".$e->getMessage());
        }

        session()->flash('success', 'Thanks for signing up! Please check your email for a confirmation.');

        return redirect()->route('pages.thank-you');
    }
}
