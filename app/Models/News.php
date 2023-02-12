<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'date',
        'link',
        'category',
        'author',

    ];

    protected $dates = [
      'date'
    ];

    public function Images():HasMany
    {
        return $this->hasMany(ImagesNews::class,'new_id','id');
    }
}
