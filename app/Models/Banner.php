<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Banner extends Model
{
    use HasFactory;
    protected $fillable = [
        'image_path',
        'title',
        'subtitle',
        'description',
        'link_url',
        'order',
        'is_active',
    ];
}
