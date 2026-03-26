<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="ERP REST API",
 *     description="Dokumentasi REST API ERP berbasis Laravel 12 dan MySQL."
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Primary API server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Masukkan token JWT dengan format: Bearer {token}"
 * )
 *
 * @OA\Parameter(
 *     parameter="PerPage",
 *     name="per_page",
 *     in="query",
 *     description="Jumlah data per halaman",
 *     @OA\Schema(type="integer", default=10, example=10)
 * )
 */
#[OA\Info(
    version: '1.0.0',
    title: 'ERP REST API',
    description: 'Dokumentasi REST API ERP berbasis Laravel 12 dan MySQL.'
)]
#[OA\Server(
    url: 'http://localhost',
    description: 'Primary API server'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT',
    description: 'Masukkan token JWT dengan format: Bearer {token}'
)]
#[OA\Parameter(
    parameter: 'PerPage',
    name: 'per_page',
    description: 'Jumlah data per halaman',
    in: 'query',
    schema: new OA\Schema(type: 'integer', default: 10, example: 10)
)]
class ApiDocumentation
{
}
