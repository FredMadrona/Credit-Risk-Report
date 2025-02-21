<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class RiskReport extends Model
{

    use HasFactory; 
    protected $fillable = [
        'risk_number', 'client_id', 'type', 'pn_number', 'branch_id', // ✅ Changed from 'branch' to 'branch_id'
        'segment', 'frp_class', 'applied_loan', 'date_rated', 'score', 
        'risk', 'risk_desc', 'next_review_date', 'remarks'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($riskReport) {
            $date = now()->format('dmY');

            // ✅ Fetch last created risk report for today
            $lastRisk = self::whereDate('created_at', now()->toDateString())
                ->latest('id')
                ->value('risk_number');

            // Extract last sequence and increment
            $sequence = $lastRisk ? (int)substr($lastRisk, -4) + 1 : 1;

            // ✅ Format risk number
            $riskReport->risk_number = 'RISK_' . $date . '_' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
