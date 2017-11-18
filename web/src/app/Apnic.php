<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apnic extends Model
{
    protected $fillable = ['registry','conutry','type'];
}
