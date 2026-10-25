<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonSignUp;
use App\Lesson;
use App\Library\Lesson\Enroll;
use App\Library\StripePayment;
use App\Mail\Admin\LessonException;
use App\Swimmer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\CardException;
use Stripe\PaymentIntent;

class SwimmerController extends Controller
{
    public function __construct(private StripePayment $stripePayment) {}

    public function store(LessonSignUp $request): RedirectResponse
    {
        $lesson = Lesson::findOrFail($request->validated('lesson_id'));

        if ($lesson->isFull()) {
            Log::warning('Someone tried to sign up for a lesson that is full.');
            session()->flash('danger', 'Sorry the lesson is full.');

            return back();
        }

        try {
            $paymentIntent = $this->stripePayment->charge(
                $request->validated('payment_method'),
                $lesson->price,
                $request->validated('email'),
                $lesson->group->type.' swim lessons for '.$request->validated('firstName').' '.$request->validated('lastName').' through The Swim School.',
                route('groups.swimmers.payment-complete'),
            );
        } catch (CardException $exception) {
            Log::warning('Group lesson payment declined: '.$exception->getMessage());
            session()->flash('error', 'Oops, something went wrong with the payment. '.$exception->getMessage());

            return back()->withInput();
        } catch (\Exception $exception) {
            $this->logErrorAndSendEmail($exception);
            session()->flash('danger', "Your registration was unsuccessful. Please call us and we'll assist you with your registration over the phone.");

            return back()->withInput();
        }

        if (StripePayment::requiresRedirect($paymentIntent)) {
            session()->put("group_lesson_payments.{$paymentIntent->id}", [
                'swimmer' => $request->validated(),
                'price' => $lesson->price,
            ]);

            return redirect()->away(StripePayment::redirectUrl($paymentIntent));
        }

        return $this->enroll($request->validated(), $lesson, $paymentIntent);
    }

    /**
     * Stripe redirects here after the customer finishes 3D Secure.
     */
    public function paymentComplete(Request $request): RedirectResponse
    {
        $paymentIntentId = (string) $request->query('payment_intent');
        $pendingPayment = session()->pull("group_lesson_payments.{$paymentIntentId}");

        if (! $pendingPayment) {
            if ($paymentIntentId && Swimmer::where('stripeChargeId', $paymentIntentId)->exists()) {
                return redirect()->route('pages.thank-you');
            }

            Log::error("No pending group lesson sign up found for payment intent: {$paymentIntentId}");
            session()->flash('danger', "Your registration was unsuccessful. Please call us and we'll assist you with your registration over the phone.");

            return redirect()->route('groups.lessons.index');
        }

        $swimmerData = $pendingPayment['swimmer'];
        $lesson = Lesson::findOrFail($swimmerData['lesson_id']);
        $paymentIntent = $this->stripePayment->retrieve($paymentIntentId);

        if (! StripePayment::isPaid($paymentIntent, $pendingPayment['price'])) {
            Log::warning("Group lesson payment {$paymentIntentId} was not completed. Status: {$paymentIntent->status}");
            session()->flash('error', 'Oops, something went wrong with the payment. Your card was not charged, please try again.');

            return redirect()->route('groups.lessons.create', [$lesson->group, $lesson])->withInput(Arr::except($swimmerData, 'payment_method'));
        }

        if ($lesson->isFull()) {
            Log::warning("Lesson ID: {$lesson->id} filled up during 3D Secure. Refunding payment intent: {$paymentIntentId}");
            $this->stripePayment->refund($paymentIntent);
            session()->flash('danger', 'Sorry the lesson filled up while you were paying. Your payment has been refunded.');

            return redirect()->route('groups.lessons.create', [$lesson->group, $lesson]);
        }

        return $this->enroll($swimmerData, $lesson, $paymentIntent);
    }

    /**
     * @param  array<string, mixed>  $swimmerData
     */
    private function enroll(array $swimmerData, Lesson $lesson, PaymentIntent $paymentIntent): RedirectResponse
    {
        try {
            (new Enroll)->handle($swimmerData, $lesson, $paymentIntent->id);
        } catch (\Exception $exception) {
            $this->logErrorAndSendEmail($exception);
            session()->flash('danger', "Your registration was unsuccessful. Please call us and we'll assist you with your registration over the phone.");

            return redirect()->route('groups.lessons.create', [$lesson->group, $lesson]);
        }

        return redirect('/thank-you');
    }

    /**
     * @todo remove this when we have a better way to handle exceptions
     *
     * @param  \Exception  $exception
     * @return void
     */
    private function logErrorAndSendEmail(\Exception $exception): void
    {
        try {
            Log::error($exception->getMessage(), [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ]);

            Mail::to(config('mail.lead_dest_emails.0'))->send(new LessonException($exception));
        } catch (\Exception $e) {
            Log::error('Failed to send Lesson Exception email');
        }
    }
}
