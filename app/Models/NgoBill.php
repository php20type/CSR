<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NgoBill extends Model
{
    protected $fillable = [
        'ngo_id',
        'user_id',
        'bill_number',
        'bill_file',
        'amount',
    ];

    public function ngo()
    {
        return $this->belongsTo(Ngo::class, 'ngo_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}