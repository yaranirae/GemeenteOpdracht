<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

protected $fillable = [
    'complaint_number',
    'category',
    'address',
    'description',
    'latitude',
    'longitude',
    'melder_id',  
    'photo_path',
    'status'
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