<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Daftar jenis exception yang tidak perlu dilaporkan (optional).
     *
     * @var array
     */
    protected $dontReport = [
        // Tambahkan exception yang tidak perlu dilaporkan, misalnya:
        // \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Render exception menjadi response HTTP.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // Tangani Validasi Gagal
        if ($exception instanceof ValidationException) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $exception->errors()
            ], 422);
        }

        // Tangani Model Tidak Ditemukan
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }

        // Tangani Autentikasi Gagal
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'message' => 'Authentication failed',
                'error' => 'You are not authenticated to access this resource.'
            ], 401);
        }

        // Tangani Semua Exception Lainnya
        return response()->json([
            'message' => 'Something went wrong',
            'error' => $exception->getMessage(),
        ], 500);
    }
}
