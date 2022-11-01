<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use Illuminate\Validation\ValidationException;

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
            parent::report($e);
        });
    }


    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof UnauthorizedHttpException) {
            return response()->json(['errors' => ['token_expired' => ['Your old session has expired. Please login again.']]], 401);
        }

        if ($exception instanceof NotFoundHttpException) {
            $msg = $exception->getMessage() ?: 'Resource not found.';

            return response()->json(['errors' => ['resource_not_found' => [$msg]]], 404);
        } elseif ($exception instanceof ModelNotFoundException) {
            return response()->json(['errors' => $exception->getMessage()], 404);
        } elseif ($exception instanceof AuthorizationException) {
            $msg = $exception->getMessage() ?: 'Forbidden.';

            return response()->json(['errors' => ['forbidden' => [$msg]]], 403);
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['errors' => ['method_not_allowed' => ['Method not allowed.']]], 405);
        } elseif ($exception instanceof HttpException) {
            if ($exception->getStatusCode() == 403) {
                $msg = $exception->getMessage() ?: 'Forbidden.';

                return response()->json(['errors' => ['forbidden' => [$msg]]], 403);
            }

            if ($exception->getStatusCode() == 401) {
                $msg = $exception->getMessage() ?: 'Unauthorized.';

                return response()->json(['errors' => ['unauthorized' => [$msg]]], 403);
            }
        } else if ($exception instanceof ValidationException) {
            $msg = $exception->getMessage() ?: 'Undefined.';
            $errors[] = $exception->errors();
            return response()->json([
                'errors' => $errors,
                'message' => $msg
            ], 403);
        }

        return response()->json([
            'message' => $exception->getMessage() ?: 'Undefined.'
        ], 403);

//        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['errors' => ['Unauthenticated.']], 401);
    }
}
