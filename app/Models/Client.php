<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Import HasFactory
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory; // Add this line

    protected $primaryKey = 'id';
    protected $appends = ['full_name'];


    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'birthday', 'applied_date'
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function riskReport(): HasMany
    {
        return $this->hasMany(RiskReport::class, 'client_id');
    }
}
