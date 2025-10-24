<?php

declare(strict_types=1);

test('Controllers should noting extend')
    ->expect('App\Http\Controllers')
    ->classes()
    ->toExtendNothing();

test('Models should extend the base model')
    ->expect('App\Models')
    ->classes()
    ->toExtend('Illuminate\Database\Eloquent\Model');

test('Dto should extend Spatie/LaravelData')
    ->expect('App\DTO')
    ->classes()
    ->toExtend('Spatie\LaravelData\Data');

test('All enum classes should be proper enums')
    ->expect('App\Enums')
    ->toBeEnums();
