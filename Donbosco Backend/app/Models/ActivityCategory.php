<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
class ActivityCategory extends Model
{
    use HasTranslations,SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];
    public $translatable = [
        'name',
        'description'
    ];
    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
