<?php

declare(strict_types=1);

test('All app files should use strict types and avoid debug functions')
    ->expect('App')
    ->toUseStrictTypes()
    ->not->toUse(['die', 'dd', 'dump']);

test('Use Laravel preset')
    ->preset()
    ->laravel()
    ->ignoring(
        [
            'App\Http\Controllers',
            'App\Exception',
            'App\Mail',
            'App\Providers\Filament',
        ]
    );

test('Code should pass basic security checks')
    ->preset()
    ->security();
