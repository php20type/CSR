<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NgoRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'ngo_name',
        'cost',
        'note'
    ];
}
