<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use App\Models\Melder;
use App\Notifications\ComplaintStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('admin_auth');
    }

    public function dashboard()
    {
        // جلب معامل الترتيب من الرابط أو استخدام القيمة الافتراضية
        $sort = request('sort', 'newest');
        
        // بناء الاستعلام مع إضافة الترتيب
        $recentComplaints = Complaint::with('melder')
            ->when($sort == 'newest', function($query) {
                $query->latest();
            })
            ->when($sort == 'oldest', function($query) {
                $query->oldest();
            })
            ->take(5)
            ->get();

        $totalComplaints = Complaint::count();
        $newComplaints = Complaint::where('status', 'new')->count();
        $resolvedComplaints = Complaint::where('status', 'resolved')->count();
        
        // Haal categorieën op voor het zoekformulier
        $categories = Complaint::distinct()->pluck('category');
        
        return view('admin.dashboard', compact(
            'recentComplaints', 
            'totalComplaints', 
            'newComplaints', 
            'resolvedComplaints', 
            'categories',
            'sort'
        ));
    }

    public function complaints(Request $request)
    {
        $query = Complaint::with('melder');

        // Uitgebreide zoekfunctionaliteit
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('id', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('category', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('address', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('melder', function($melderQuery) use ($searchTerm) {
                      $melderQuery->where('naam', 'LIKE', "%{$searchTerm}%")
                                 ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                                 ->orWhere('mobiel', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        // Filteren op status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filteren op categorie
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        // Filteren op melder - هذا هو التصحيح
        if ($request->has('melder_name') && !empty($request->melder_name)) {
            $query->whereHas('melder', function($melderQuery) use ($request) {
                $melderQuery->where('naam', 'LIKE', "%{$request->melder_name}%");
            });
        }

        $complaints = $query->latest()->paginate(10);
        
        // Haal alle unieke categorieën op voor het dropdown menu
        $categories = Complaint::distinct()->pluck('category');
        
        // Haal alle melders op voor het dropdown menu
        $allMelders = Melder::withCount('complaints')
                            ->orderBy('naam')
                            ->get();

        return view('admin.complaints', compact('complaints', 'categories', 'allMelders'));
    }

    public function showComplaint($id)
    {
        $complaint = Complaint::with('melder')->findOrFail($id); 
        return view('admin.complaint-details', compact('complaint'));
    }

    public function updateComplaintStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,in_progress,resolved',
            'message' => 'nullable|string|max:500'
        ]);

        $complaint = Complaint::with('melder')->findOrFail($id); 
        $oldStatus = $complaint->status;
        $complaint->status = $request->status;
        $complaint->save();

        // Stuur notificatie als aangevinkt - update voor melder
        if ($request->has('send_notification') && $complaint->melder && $complaint->melder->email) {
            $melder = $complaint->melder;
            $message = $request->message ?: $this->getDefaultMessage($request->status);
            
            // Stuur notificatie (email)
            // يمكنك إضافة نظام الإشعارات هنا
            // Mail::to($melder->email)->send(new ComplaintStatusMail($complaint, $message));
            
            // Log de notificatie (optioneel)
            \Log::info("Status update notification sent to melder {$melder->id} for complaint {$complaint->id}");
        }

        return redirect()->back()->with('success', 'Status succesvol bijgewerkt.' . ($request->has('send_notification') ? ' Notificatie is verzonden.' : ''));
    }

    private function getDefaultMessage($status)
    {
        switch ($status) {
            case 'in_progress':
                return 'Uw klacht is in behandeling genomen. We houden u op de hoogte van verdere ontwikkelingen.';
            case 'resolved':
                return 'Uw klacht is opgelost. Bedankt voor uw melding.';
            default:
                return 'De status van uw klacht is bijgewerkt.';
        }
    }

    public function deleteComplaint($id)
    {
        $complaint = Complaint::findOrFail($id);
        
        // Verwijder de foto als deze bestaat
        if ($complaint->photo_path) {
            Storage::disk('public')->delete($complaint->photo_path);
        }
        
        $complaint->delete();

        return redirect()->route('admin.complaints')->with('success', 'Klacht succesvol verwijderd.');
    }

    /**
     * إضافة جديدة: عرض جميع المشتكين
     */
    public function melders(Request $request)
    {
        $query = Melder::withCount('complaints');

        // البحث عن المشتكين
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('naam', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('mobiel', 'LIKE', "%{$searchTerm}%");
            });
        }

        $melders = $query->orderBy('naam')->paginate(15);

        return view('admin.melders', compact('melders'));
    }

    /**
     * إضافة جديدة: عرض تفاصيل مشتكي معين
     */
    public function showMelder($id)
    {
        $melder = Melder::with(['complaints' => function($query) {
            $query->latest();
        }])->findOrFail($id);

        return view('admin.melder-details', compact('melder'));
    }
}