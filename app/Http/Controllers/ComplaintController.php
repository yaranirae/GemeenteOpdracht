<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;

class ComplaintController extends Controller
{
    public function index()
    {
        return view('complaints.index');
    }

    public function create()
    {
        return view('complaints.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|in:omgewaaide bomen,kapotte straatverlichting,zwerfvuil,',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048'
        ]);

        // حفظ الصورة إذا تم رفعها
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('complaints', 'public');
            $validated['photo_path'] = $path;
        }

        // حفظ الشكوى في قاعدة البيانات
        Complaint::create($validated);

        return redirect()->route('complaints.thankyou');
    }

    public function thankyou()
    {
        return view('complaints.thankyou');
    }
}