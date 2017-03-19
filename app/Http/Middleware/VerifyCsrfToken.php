<?php

namespace App\Http\Middleware;

use App\Http\Controllers\MobileController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'mlogin',
        'toast_api/log_attendance',
    ];
}
