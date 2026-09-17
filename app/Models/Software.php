<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    /** @use HasFactory<\Database\Factories\SoftwareFactory> */
    use HasFactory;
    protected $fillable = [
        'icon',
        'subcategory_id',
        'title',
        'slug',
        'short_description',
        'category_id',
        'download_button_text',
        'download_url',
        'official_button_text',
        'official_website',
        'screenshots',
        'description',
        'downloads_count',
        'rating',
    ];
     protected $casts = [
        'screenshots' => 'array',
    ];

    public function category()
{
    return $this->belongsTo(Category::class);
}

public function subcategory()
{
    return $this->belongsTo(Subcategory::class);
}
public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
