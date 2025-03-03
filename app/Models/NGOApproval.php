<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NGOApproval extends Model
{
    protected $table = 'ngo_approvals';
    protected $fillable = ['ngo_id', 'admin_id', 'approved'];

    public function ngo()
    {
        return $this->belongsTo(NGO::class, 'ngo_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }
}