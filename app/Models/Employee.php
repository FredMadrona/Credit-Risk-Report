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
        'branch_id',
        'department_id',
        'employee_status',
        'job_position',
        'birth_date',
        'hire_date',
        'date_regularized',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
        'date_regularized' => 'date',
    ];

    public function branch() : BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    
    public function manager()
{
    return $this->belongsTo(Employee::class, 'branch_manager_id');
}

    

}
