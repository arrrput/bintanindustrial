<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Gagal saat submit form (bukan AJAX): kembali ke halaman yang sama,
        // input tetap terisi, dan pesan error ditampilkan lewat SweetAlert2.
        $this->renderable(function (Throwable $e, Request $request) {
            if ($request->isMethodSafe() || $request->expectsJson()) {
                return null;
            }

            // Biarkan Laravel menangani validasi, login & response bawaan seperti biasa
            if ($e instanceof ValidationException
                || $e instanceof AuthenticationException
                || $e instanceof HttpResponseException) {
                return null;
            }

            if ($e instanceof HttpExceptionInterface) {
                $message = match ($e->getStatusCode()) {
                    419 => 'Your session has expired. Please try submitting the form again.',
                    413 => 'The upload is too large for this server (max '
                        . \App\Support\UploadLimits::human(\App\Support\UploadLimits::totalBytes())
                        . ' per save). Please choose smaller files or upload fewer at a time.',
                    default => null,
                };

                if ($message === null) {
                    return null;
                }

                // 413: request body was discarded, so there is no input to restore
                $redirect = redirect()->back()->with('error', $message);

                return $e->getStatusCode() === 413
                    ? $redirect
                    : $redirect->withInput($request->except(array_merge($this->dontFlash, ['_token'])));
            }

            return redirect()->back()
                ->withInput($request->except(array_merge($this->dontFlash, ['_token'])))
                ->with('error', 'Something went wrong while saving your changes. Please try again.');
        });
    }
}
