<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
class Audit extends Model
{
    use HasTranslations, SoftDeletes;
    protected $fillable = ['user_id', 'action', 'description', 'model_type', 'model_id', 'old_value', 'new_value'];
    public $translatable = [
        'description',
        'old_value',
        'new_value',
    ];
    protected $casts = [
        'description' => 'array',
        'old_value' => 'array',
        'new_value' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
