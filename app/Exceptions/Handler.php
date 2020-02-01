<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        /**
         * Redirect to home with an authorization exception.
         * This was added to handle locking down the 'email-manager' route.
         */
        if ($exception instanceof AuthorizationException) {
            return redirect('/');
        }

        /**
         * This method will redirect you to the login page when the 419 error happens.
         * This login error happens because you try to login without refreshing the page, so your csrf token
         * does not match.
         */
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            session()->flash('danger', 'Please Login Again');
            return redirect()->route('login');
        }

        return parent::render($request, $exception);
    }
}
