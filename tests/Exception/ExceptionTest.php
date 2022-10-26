<?php

use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\MissingAttributeException;
use Illuminate\Database\LazyLoadingViolationException;
use Kainiklas\LaravelStrictMode\Tests\Mocks\Model1;

it('throwsAnExceptionOnLazyLoading', function () {
    Model1::create();
    Model1::create();
    Model1::create();

    $models = Model1::get();
    $models[0]->modelTwos;
})->throws(LazyLoadingViolationException::class);

it('throwsAnExceptionOnMissingAttribute', function () {
    Model1::create();
    Model1::create();

    $models = Model1::get();
    $models[0]->this_attribute_does_not_exist;
})->throws(MissingAttributeException::class);

it('throwsAnExceptionOnMissingFillable', function () {
    Model1::create([
        'non_fillable_attribute' => 'test',
    ]);
})->throws(MassAssignmentException::class);
