<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'user_id', 'donation_amount', 'status'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function project(): HasOne {
        return $this->hasOne(Project::class);
    }
}
