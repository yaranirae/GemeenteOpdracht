<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Melder extends Model
{
    use HasFactory;

    protected $fillable = [
        'naam',
        'email',
        'mobiel'
    ];

    // العلاقة مع الشكاوى
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}