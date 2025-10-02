<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'address',
        'description',
        'latitude',
        'longitude',
        'name',
        'email',
        'phone',
        'photo_path',
        'status',
        'melder_id' 
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function getPhotoUrlAttribute()
    {
        if ($this->photo_path) {
            return asset('storage/' . $this->photo_path);
        }
        return null;
    }

    // العلاقة مع المشتكي
    public function melder()
    {
        return $this->belongsTo(Melder::class);
    }
}