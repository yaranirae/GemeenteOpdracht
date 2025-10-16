<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // أضف هذا

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
        'status',
        'anonymized_at'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'anonymized_at' => 'datetime' // أضف هذا
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

    public function anonymizeOldData()
    {
        // إذا كنت تريد تجهيل الشكاوى نفسها
        $oldComplaints = Complaint::where('created_at', '<', Carbon::now()->subDays(3))
                                  ->whereNull('anonymized_at')
                                  ->get();
        
        foreach ($oldComplaints as $complaint) {
            $complaint->update([
                'address' => 'Geanonimiseerd', // تجهيل العنوان فقط
                'anonymized_at' => Carbon::now()
            ]);
        }
        
        return $oldComplaints->count();
    }
}