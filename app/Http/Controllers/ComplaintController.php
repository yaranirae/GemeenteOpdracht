<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Complaint;
use App\Models\Melder;
use App\Mail\ComplaintStatusMail;

class ComplaintController extends Controller
{
    /**
     * عرض صفحة الشكاوى الرئيسية
     */
    public function index(Request $request)
    {
        // إذا كان هناك بيانات موقع مرسلة من الخريطة، احفظها في الجلسة
        if ($request->has('address') && $request->has('lat') && $request->has('lng')) {
            session([
                'location_data' => [
                    'address' => $request->get('address'),
                    'latitude' => $request->get('lat'),
                    'longitude' => $request->get('lng')
                ]
            ]);
            // return redirect()->route('complaints.index');
            $complaints = Complaint::with('melder')->latest()->take(10)->get();
            return view('complaints.index', compact('complaints'));
        }

        $complaints = Complaint::with('melder')->latest()->take(10)->get();
        return view('complaints.index', compact('complaints'));
    }

    /**
     * عرض نموذج إنشاء شكوى جديدة
     */

    public function create()
    {
        // الحصول على بيانات الموقع من الجلسة إذا كانت موجودة
        $locationData = session('location_data');


        if ($locationData) {
            $address = $locationData['address'];
            $lat = $locationData['latitude'];
            $lng = $locationData['longitude'];

            // مسح بيانات الجلسة بعد استخدامها
            // session()->forget('location_data');
        } else {
            $address = $lat = $lng = null;
        }

        return view('complaints.create', compact('address', 'lat', 'lng'));
    }

    /**
     * حفظ الشكوى الجديدة
     */

    /**
     * معالجة بيانات المشتكي
     */
    private function handleMelderData(array $validated)
    {
        if (!empty($validated['email'])) {
            $melder = Melder::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'naam' => $validated['name'] ?? 'Anoniem',
                    'mobiel' => $validated['phone'] ?? null
                ]
            );
            return $melder->id;
        } elseif (!empty($validated['name'])) {
            $melder = Melder::create([
                'naam' => $validated['name'],
                'mobiel' => $validated['phone'] ?? null,
                'email' => null
            ]);
            return $melder->id;
        }

        return null;
    }

    /**
     * معالجة رفع الصورة
     */
    private function handlePhotoUpload(Request $request)
    {
        if ($request->hasFile('photo')) {
            return $request->file('photo')->store('complaints', 'public');
        }

        return null;
    }

    /**
     * إنشاء رقم شكوى فريد
     */
    private function generateComplaintNumber()
    {
        return 'COMP-' . date('Ymd') . '-' . strtoupper(Str::random(6));
    }

    /**
     * صفحة الشكر بعد تقديم الشكوى
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'category' => 'required|in:omgewaaide bomen,kapotte straatverlichting,zwerfvuil,overig',
                'address' => 'required|string|max:255',
                'description' => 'required|string|min:10|max:1000',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:20',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
            ]);

            $melderId = $this->handleMelderData($validated);
            $photoPath = $this->handlePhotoUpload($request);

            $complaint = Complaint::create([
                'category' => $validated['category'],
                'address' => $validated['address'],
                'description' => $validated['description'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'melder_id' => $melderId,
                'photo_path' => $photoPath,
                'status' => 'new',
                'complaint_number' => $this->generateComplaintNumber()
            ]);

            DB::commit();

            session()->forget('location_data');

            return redirect()->route('complaints.thankyou')
                ->with('complaint_number', $complaint->complaint_number)
                ->with('complaint_category', $complaint->category)
                ->with('success', 'Successfully submitted your complaint.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Complaint storage failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to submit your complaint: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function thankyou()
    {
        $complaint_number = session('complaint_number');
        $complaint_category = session('complaint_category');
        // dd($complaint_number);
        // if (!$complaint_number) {
        //     return redirect()->route('complaints.create');
        // }

        return view('complaints.thankyou', compact('complaint_number', 'complaint_category'));
    }
    /**
     * إرسال رسالة مخصصة إلى المبلغ
     */
    public function sendCustomMessage(Request $request, $id)
{
    $complaint = Complaint::with('melder')->findOrFail($id);
    
    $validated = $request->validate([
        'message' => 'required|string|min:10|max:1000'
    ]);
    
    if (!$complaint->melder || !$complaint->melder->email) {
        return redirect()->back()
            ->with('error', 'Geen e-mailadres beschikbaar voor deze klager.');
    }
    
    try {
        // ✅ إرسال البريد مع الرسالة المخصصة
        Mail::to($complaint->melder->email)
            ->send(new ComplaintStatusMail($complaint, $validated['message']));
        
        return redirect()->back()
            ->with('success', 'Bericht succesvol verzonden naar ' . $complaint->melder->naam);
            
    } catch (\Exception $e) {
        \Log::error('Failed to send custom message: ' . $e->getMessage());
        
        return redirect()->back()
            ->with('error', 'Fout bij het verzenden van bericht: ' . $e->getMessage());
    }
}
}