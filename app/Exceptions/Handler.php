<?php

namespace App\Exceptions;

use Doctrine\DBAL\Query\QueryException;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Testing\HttpException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,

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
        if ($exception instanceof ValidationException){
            $errors = $exception->validator->errors()->getMessages();

            $singleErros = Collect(array_keys($errors))->reduce(function ($carry, $item) use ($errors) {

                $carry[$item] = $errors[$item][0];

                return $carry;
            }, []);
            return response()->json(["errors" => $singleErros], 422);
        }

        if ($exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => 'Not found'
            ], 404);
        } elseif ($exception instanceof HttpException) {
            return response()->json([
                'error' => 'Unsupported Media Type'
            ], 415);
        } elseif ($exception instanceof AuthenticationException) {
            return response()->json([
                'error' => 'Forbidden. Unauthenticated.'
            ], 403);
        } elseif ($exception instanceof QueryException) {
            return response()->json([
                'error' => 'Unresolvable Query.',
                'message' => $e->getMessage()

            ], 400);
        }



        return parent::render($request, $exception);
    }
}
