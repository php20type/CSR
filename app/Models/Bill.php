<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = ['ngo_id', 'bill_number', 'amount', 'bill_file'];

    public function ngo()
    {
        return $this->belongsTo(NGO::class);
    }
}
