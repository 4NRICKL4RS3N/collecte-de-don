<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project_image extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'url', 'type', 'filename', 'mime_type'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
