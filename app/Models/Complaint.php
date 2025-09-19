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
}