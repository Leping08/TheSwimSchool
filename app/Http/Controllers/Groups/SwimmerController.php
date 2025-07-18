<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonSignUp;
use App\Library\Lesson\Enroll;
use App\Mail\Admin\LessonException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class SwimmerController extends Controller
{
    /**
     * @param  LessonSignUp  $request
     * @return Redirect
     */
    public function store(LessonSignUp $request)
    {
        try {
            (new Enroll)->handle();
        } catch (\Exception $exception) {
            $this->logErrorAndSendEmail($exception);
            session()->flash('danger', "Your registration was unsuccessful. Please call us and we'll assist you with your registration over the phone.");

            return back();
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
