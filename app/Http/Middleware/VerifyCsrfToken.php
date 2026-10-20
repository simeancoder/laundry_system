<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestForgery as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'report*',
        'reports*',
        'reports-preview*',
        'inventory*',
        'pickup-and-delivery*',
        'PickupAndDelivery*',
        'payment*',
        'payments*',
        'employee*',
        'employees*',
        'machine*',
        'machines*',
        'promotion*',
        'promotions*',
        'discount*',
        'discounts*',
        'discount&promotion*',
        'notification*',
        'notifications*',
        'setting*',
        'settings*',
    ];
}
