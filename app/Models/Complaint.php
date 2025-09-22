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
        'status'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    // علاقة مع المستخدم إذا أردت إضافة نظام مستخدمين
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}