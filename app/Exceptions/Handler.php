<?php

namespace App\Exceptions;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

        protected function unauthenticated($request, AuthenticationException $exception)
    {
        // Check if the request expects a JSON response (e.g., API requests)
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 401, // Use 401 for Unauthorized
                'message' => 'Unauthenticated. Please provide a valid API token.',
            ], 401);
        }

        // For web requests, you might still want to redirect to a login page
        // return redirect()->guest($exception->redirectTo() ?? route('login'));
        // Or if you want to return a simple unauthorized response for non-JSON requests
        return response('Unauthenticated.', 401);
    }
}
