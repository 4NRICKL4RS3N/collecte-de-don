<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function donations(): HasMany {
        return $this->hasMany(Donation::class);
    }

    public function isAdmin(): bool
    {
        return $this->is_admin == 1;
    }

    public function isClient(): bool
    {
        return $this->is_admin == 0;
    }

    public function createDonation($project_id, $donation_amount): Donation {
        return Donation::create([
            'project_id' => $project_id,
            'user_id' => $this->id,
            'donation_amount' => $donation_amount,
            'status' => 0,
        ]);
    }

    public function createPaymentIntent($project_id, $donation_amount) {
        $donation = $this->createDonation($project_id, $donation_amount);
        return PaymentIntent::create([
            'amount' => $donation_amount,
            'currency' => 'eu',
            'payment_method_types' => ['card', 'paypal'],
            'metadata' => [
                'name' => $this->name,
                'email' => $this->email,
                'donation_id' => $donation->id,
            ],
        ], [
            'locale' => 'fr',
        ]);
    }
}
