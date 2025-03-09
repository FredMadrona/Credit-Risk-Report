<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_date',
        'hire_date',
        'date_regularized',
    ];

    public function branch() : BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    
    public function managedBranch()
    {
        return $this->hasOne(Branch::class, 'branch_manager_id');
    }
    

}
