<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Response;
use KeycloakGuard\Exceptions\TokenException;

use Core\Domain\Shared\Exception\{
    EntityValidationException,
    RepositoryException,
    NotFoundException
};

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

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundException)
            return $this->showError($exception->getMessage(), Response::HTTP_NOT_FOUND);

        if ($exception instanceof EntityValidationException)
            return $this->showError($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);

        if ($exception instanceof RepositoryException)
            return $this->showError($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);

        if ($exception instanceof TokenException)
            return $this->showError($exception->getMessage(), 401);

        return parent::render($request, $exception);
    }

    private function showError(string $message, int $statusCode)
    {
        return response()->json([
            'message' => $message
        ], $statusCode);
    }
}
