<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['donation_id', 'transaction_id', 'donation_amount', 'method', 'status'];

    public function donation() {
        return $this->belongsTo(Donation::class);
    }
}
