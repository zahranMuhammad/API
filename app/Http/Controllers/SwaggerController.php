<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API Dokumentasi E-Commerce",
 *      description="Dokumentasi API untuk projek E-Commerce Laravel",
 *      @OA\Contact(
 *          email="zahranmhhhhhh@gmail.com"
 *      ),
 * )
 *
 * @OA\Server(
 *      url="http://127.0.0.1:8000/api",
 *      description="Local API Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Masukkan token Sanctum di sini. Contoh: Bearer 1|yourapitokenhere"
 * )
 */
class SwaggerController extends Controller
{
    // Controller ini tidak perlu method, hanya untuk dokumentasi
}
