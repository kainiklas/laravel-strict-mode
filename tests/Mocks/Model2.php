<?php

namespace Kainiklas\LaravelStrictMode\Tests\Mocks;

use Illuminate\Database\Eloquent\Model;

class Model2 extends Model
{
    public $table = 'test_model2';

    public $timestamps = false;

    protected $fillable = [];
}
