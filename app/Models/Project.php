<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'location', 'status', 'donation_target', 'donation_collected', 'date_start', 'date_end'];

    public function project_objectives(): HasMany
    {
        return $this->hasMany(Project_objective::class);
    }

    public function project_images(): HasMany
    {
        return $this->hasMany(Project_image::class);
    }

    public function getStatus() {
        if ($this->status == 0) {
            return "en attente";
        }
        if ($this->status == 1) {
            return "en cours";
        }
        if ($this->status == 2) {
            return "terminé";
        }
    }
}
