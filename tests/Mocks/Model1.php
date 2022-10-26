<?php

namespace Kainiklas\LaravelStrictMode\Tests\Mocks;

use Illuminate\Database\Eloquent\Model;

class Model1 extends Model
{
    public $table = 'test_model1';

    public $timestamps = false;

    protected $fillable = [];

    public function modelTwos()
    {
        return $this->hasMany(Model2::class, 'model_1_id');
    }
}
