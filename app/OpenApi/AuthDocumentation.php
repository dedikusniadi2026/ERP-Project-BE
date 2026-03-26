<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

/**
 * @OA\Schema(
 *     schema="LoginRequest",
 *     type="object",
 *     required={"email","password"},
 *     @OA\Property(property="email", type="string", format="email", example="admin@erp.local"),
 *     @OA\Property(property="password", type="string", format="password", example="password")
 * )
 *
 * @OA\Schema(
 *     schema="RegisterRequest",
 *     type="object",
 *     required={"name","email","password","password_confirmation"},
 *     @OA\Property(property="name", type="string", example="ERP Admin"),
 *     @OA\Property(property="email", type="string", format="email", example="admin@erp.local"),
 *     @OA\Property(property="password", type="string", format="password", example="password"),
 *     @OA\Property(property="password_confirmation", type="string", format="password", example="password")
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="ERP Admin"),
 *     @OA\Property(property="email", type="string", format="email", example="admin@erp.local")
 * )
 *
 * @OA\Schema(
 *     schema="AuthSuccessResponse",
 *     type="object",
 *     @OA\Property(property="access_token", type="string"),
 *     @OA\Property(property="token_type", type="string", example="bearer"),
 *     @OA\Property(property="expires_in", type="integer", example=3600),
 *     @OA\Property(property="user", ref="#/components/schemas/User")
 * )
 *
 * @OA\Post(
 *     path="/api/v1/auth/register",
 *     operationId="register",
 *     tags={"Auth"},
 *     summary="Register user baru",
 *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/RegisterRequest")),
 *     @OA\Response(response=201, description="Register berhasil")
 * )
 *
 * @OA\Post(
 *     path="/api/v1/auth/login",
 *     operationId="login",
 *     tags={"Auth"},
 *     summary="Login dan dapatkan token JWT",
 *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/LoginRequest")),
 *     @OA\Response(
 *         response=200,
 *         description="Login berhasil",
 *         @OA\JsonContent(ref="#/components/schemas/AuthSuccessResponse")
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/v1/auth/me",
 *     operationId="me",
 *     tags={"Auth"},
 *     security={{"bearerAuth":{}}},
 *     summary="Lihat profile user login",
 *     @OA\Response(response=200, description="Sukses")
 * )
 *
 * @OA\Post(
 *     path="/api/v1/auth/logout",
 *     operationId="logout",
 *     tags={"Auth"},
 *     security={{"bearerAuth":{}}},
 *     summary="Logout user",
 *     @OA\Response(response=200, description="Logout berhasil")
 * )
 */
#[OA\Schema(
    schema: 'LoginRequest',
    required: ['email', 'password'],
    properties: [
        new OA\Property(property: 'email', type: 'string', format: 'email', example: 'admin@erp.local'),
        new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'RegisterRequest',
    required: ['name', 'email', 'password', 'password_confirmation'],
    properties: [
        new OA\Property(property: 'name', type: 'string', example: 'ERP Admin'),
        new OA\Property(property: 'email', type: 'string', format: 'email', example: 'admin@erp.local'),
        new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password'),
        new OA\Property(property: 'password_confirmation', type: 'string', format: 'password', example: 'password'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'User',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'ERP Admin'),
        new OA\Property(property: 'email', type: 'string', format: 'email', example: 'admin@erp.local'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'AuthSuccessResponse',
    properties: [
        new OA\Property(property: 'access_token', type: 'string'),
        new OA\Property(property: 'token_type', type: 'string', example: 'bearer'),
        new OA\Property(property: 'expires_in', type: 'integer', example: 3600),
        new OA\Property(property: 'user', ref: '#/components/schemas/User'),
    ],
    type: 'object'
)]
class AuthDocumentation
{
    /**
     * @OA\PathItem(path="/api/v1/auth/register")
     * @OA\Post(
     *     path="/api/v1/auth/register",
     *     operationId="register",
     *     tags={"Auth"},
     *     summary="Register user baru",
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/RegisterRequest")),
     *     @OA\Response(response=201, description="Register berhasil")
     * )
     */
    public function register(): void
    {
    }

    #[OA\Post(
        path: '/api/v1/auth/register',
        operationId: 'register',
        tags: ['Auth'],
        summary: 'Register user baru',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/RegisterRequest')),
        responses: [new OA\Response(response: 201, description: 'Register berhasil')]
    )]
    public function registerAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/auth/login")
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     operationId="login",
     *     tags={"Auth"},
     *     summary="Login dan dapatkan token JWT",
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/LoginRequest")),
     *     @OA\Response(response=200, description="Login berhasil")
     * )
     */
    public function login(): void
    {
    }

    #[OA\Post(
        path: '/api/v1/auth/login',
        operationId: 'login',
        tags: ['Auth'],
        summary: 'Login dan dapatkan token JWT',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/LoginRequest')),
        responses: [new OA\Response(response: 200, description: 'Login berhasil', content: new OA\JsonContent(ref: '#/components/schemas/AuthSuccessResponse'))]
    )]
    public function loginAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/auth/me")
     * @OA\Get(
     *     path="/api/v1/auth/me",
     *     operationId="me",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     summary="Lihat profile user login",
     *     @OA\Response(response=200, description="Sukses")
     * )
     */
    public function me(): void
    {
    }

    #[OA\Get(
        path: '/api/v1/auth/me',
        operationId: 'me',
        tags: ['Auth'],
        security: [['bearerAuth' => []]],
        summary: 'Lihat profile user login',
        responses: [new OA\Response(response: 200, description: 'Sukses')]
    )]
    public function meAttr(): void
    {
    }

    /**
     * @OA\PathItem(path="/api/v1/auth/logout")
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     operationId="logout",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     summary="Logout user",
     *     @OA\Response(response=200, description="Logout berhasil")
     * )
     */
    public function logout(): void
    {
    }

    #[OA\Post(
        path: '/api/v1/auth/logout',
        operationId: 'logout',
        tags: ['Auth'],
        security: [['bearerAuth' => []]],
        summary: 'Logout user',
        responses: [new OA\Response(response: 200, description: 'Logout berhasil')]
    )]
    public function logoutAttr(): void
    {
    }
}
