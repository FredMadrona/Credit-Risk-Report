<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['branch_name', 'branch_code', 'branch_address', 'branch_phone', 'branch_email', 'branch_manager_id'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function riskReport()
    {
        return $this->hasMany(RiskReport::class);
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'branch_manager_id');
    }
}
