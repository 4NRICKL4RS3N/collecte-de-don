<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

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

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
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
        return "en attente";
    }

    public function deleteObjectives() {
        foreach ($this->project_objectives as $project_objective) {
            $project_objective->delete();
        }
    }

    public function deleteImages() {
        foreach ($this->project_images as $project_image) {
            $path = str_replace('/storage', 'public', $project_image);
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
            $project_image->delete();
        }
    }
}
