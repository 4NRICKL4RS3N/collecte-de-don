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

    function getParagraphsDescription()
    {
        $content = preg_replace('/<p>\s*<\/p>/', '', $this->description);
        preg_match_all('/<p>(.*?)<\/p>/s', $content, $matches);
        $paragraphs = array_filter(array_map('trim', $matches[1]));
        return $paragraphs;
    }

    function getImagesWidthHeight() {
        $images = $this->project_images;
        $widthHeight = [];
        foreach ($images as $image) {
            [$width, $height] = getimagesize(public_path($image->url));
            $widthHeight[] = [
                "width" => $width,
                "height" => $height,
            ];
        }
        return $widthHeight;
    }

    function getProgress() {
        return ($this->donation_target > 0) ? round(($this->donation_collected / $this->donation_target) * 100, 2) : 0;
    }

}
