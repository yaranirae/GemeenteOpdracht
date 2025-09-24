<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Mail\ComplaintStatusMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,in_progress,resolved',
            'message' => 'nullable|string|max:500'
        ]);

        $complaint = Complaint::findOrFail($id);
        $oldStatus = $complaint->status;
        $complaint->status = $request->status;
        $complaint->save();

        // إرسال البريد الإلكتروني إذا كان هناك بريد للمشتكي
        if ($complaint->email) {
            try {
                Mail::to($complaint->email)
                    ->send(new ComplaintStatusMail($complaint, $request->message));
                
                $emailStatus = ' en notificatie is verzonden';
            } catch (\Exception $e) {
                $emailStatus = ' maar notificatie kon niet worden verzonden';
            }
        } else {
            $emailStatus = '';
        }

        return redirect()->back()->with('success', 'Status bijgewerkt' . $emailStatus);
    }

    /**
     * إرسال رسالة مخصصة للمشتكي
     */
    public function sendCustomMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'subject' => 'required|string|max:200'
        ]);

        $complaint = Complaint::findOrFail($id);

        if (!$complaint->email) {
            return redirect()->back()->with('error', 'Geen e-mailadres beschikbaar voor deze klacht.');
        }

        try {
            Mail::to($complaint->email)
                ->send(new ComplaintStatusMail($complaint, $request->message));
            
            return redirect()->back()->with('success', 'Bericht succesvol verzonden naar klager.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Bericht kon niet worden verzonden: ' . $e->getMessage());
        }
    }
}

