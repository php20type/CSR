<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdditionalFund extends Model
{
    use HasFactory;
    protected $fillable = [
        'added_by',
        'amount',
        'release_date',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

}
