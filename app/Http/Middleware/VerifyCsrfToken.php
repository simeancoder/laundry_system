<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'reports*',
        'reports-preview*',
        'inventory*',
        'pickup-and-delivery*',
        'PickupAndDelivery*',
        'payment*',
        'payments*',
    ];
}
