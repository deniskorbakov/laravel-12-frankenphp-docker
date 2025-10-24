<?php

declare(strict_types=1);

test('Controllers should have Controller suffix')
    ->expect('App\Http\Controllers')
    ->classes()
    ->toHaveSuffix('Controller');

test('Dto should have DTO suffix')
    ->expect('App\DTO')
    ->classes()
    ->toHaveSuffix('DTO');

test('Models should be in singular')
    ->expect('App\Models')
    ->classes()
    ->toHaveSuffix('');
