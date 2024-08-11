<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
    }

    public function render($request, Throwable $exception)
    {
        // Verifica si es una excepción HttpException
        if ($exception instanceof HttpException && $exception->getStatusCode() === 419) {
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado, por favor inicia sesión nuevamente.');
        }

        // Verifica si es una excepción TokenMismatchException
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect()->route('login')->with('message', 'Tu sesión ha expirado, por favor inicia sesión nuevamente.');
        }

        // Para otras excepciones
        return parent::render($request, $exception);
    }
}
