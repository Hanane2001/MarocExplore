<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;
#[OA\Info(version: "1.0.0", title: "MyExp API", description: "API documentation for MyExp application")]
#[OA\SecurityScheme(
    securityScheme: "sanctumAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "Token"
)]
abstract class Controller
{
    //
}
