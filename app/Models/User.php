<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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

    /**
     * @throws GuzzleException
     */
    function convertMGAtoUSD($amountMGA): float|int
    {
        $client = new Client();
        $endpoint = "https://v6.exchangerate-api.com/v6/".config('services.exchangerate_api.key')."/latest/MGA";
        $response = $client->get($endpoint);
        $data = json_decode($response->getBody(), true);
        $rate = $data['conversion_rates']['USD'];
        return $amountMGA * $rate;
    }

    public function createDonation($project_id, $donation_amount): Donation {
        return Donation::create([
            'project_id' => $project_id,
            'user_id' => $this->id,
            'donation_amount' => $donation_amount,
            'status' => 0,
        ]);
    }

    /**
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function createPaymentIntent($project_id, $donation_amount) {
        $donation = $this->createDonation($project_id, $donation_amount);
        $exchanged_amount = $this->convertMGAtoUSD($donation_amount);
        return PaymentIntent::create([
            'amount' => round($exchanged_amount * 100), // Convert to cents
            'currency' => 'usd',
            'payment_method_types' => ['card', 'paypal'],
            'metadata' => [
                'name' => $this->name,
                'email' => $this->email,
                'donation_id' => $donation->id,
            ],
        ], [
            'locale' => 'fr', // Add locale here
        ]);
    }
}
