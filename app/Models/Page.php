<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'title'];

    private function page_elements(): HasMany
    {
        return $this->hasMany(Page_element::class);
    }

    public function get_page_elements() {
        return $this->page_elements()->get()->keyBy('key');
    }
}
