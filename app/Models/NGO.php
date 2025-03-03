<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NGO extends Model
{
    use HasFactory;
    protected $table = 'ngos';
    protected $fillable = ['location', 'name', 'team_responsible', 'food_type', 'quantity', 'cost_per_unit', 'other_costs', 'total_cost', 'payment_mode', 'remaining_budget', 'remarks'];

    public function approvals()
    {
        return $this->hasMany(NGOApproval::class, 'ngo_id');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class, 'ngo_id');
    }
}
