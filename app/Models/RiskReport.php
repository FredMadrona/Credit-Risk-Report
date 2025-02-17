<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class RiskReport extends Model
{


    protected $fillable = [
        'risk_number', 'client_id', 'type', 'pn_number', 'branch', 'segment', 'frp_class',
        'applied_load', 'date_rated', 'score', 'risk', 'risk_desc', 'next_review_date', 'remarks'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($riskReport) {
            $date = now()->format('dmY');
            $lastRisk = self::whereDate('created_at', now()->toDateString())->count() + 1;
            $riskReport->risk_number = 'RISK_' . $date . '_' . str_pad($lastRisk, 4, '0', STR_PAD_LEFT);
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
    
}
