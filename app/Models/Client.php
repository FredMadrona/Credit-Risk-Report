<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $primaryKey = 'id';
    protected $appends = ['full_name'];


    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'birthday', 'applied_date'
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function riskReports(): HasMany
    {
        return $this->hasMany(RiskReport::class, 'client_id');
    }
}
