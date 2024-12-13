<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page_element extends Model
{
    use HasFactory;

    protected $fillable = ['page_id', 'type', 'key', 'content'];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
