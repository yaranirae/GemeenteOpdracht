<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
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
        $recentComplaints = Complaint::latest()->take(5)->get();
        $totalComplaints = Complaint::count();
        $newComplaints = Complaint::where('status', 'new')->count();
        $resolvedComplaints = Complaint::where('status', 'resolved')->count();
        
        // Haal categorieën op voor het zoekformulier
        $categories = Complaint::distinct()->pluck('category');
        
        return view('admin.dashboard', compact('recentComplaints', 'totalComplaints', 'newComplaints', 'resolvedComplaints', 'categories'));
    }

    public function complaints(Request $request)
    {
        $query = Complaint::query();

        // Uitgebreide zoekfunctionaliteit
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('id', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('category', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('address', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
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

        $complaints = $query->latest()->paginate(10);
        
        // Haal alle unieke categorieën op voor het dropdown menu
        $categories = Complaint::distinct()->pluck('category');

        return view('admin.complaints', compact('complaints', 'categories'));
    }

    public function showComplaint($id)
    {
        $complaint = Complaint::findOrFail($id);
        return view('admin.complaint-details', compact('complaint'));
    }

    public function updateComplaintStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,in_progress,resolved',
            'message' => 'nullable|string|max:500'
        ]);

        $complaint = Complaint::findOrFail($id);
        $oldStatus = $complaint->status;
        $complaint->status = $request->status;
        $complaint->save();

        // Stuur notificatie als aangevinkt
        if ($request->has('send_notification') && $complaint->user) {
            $user = $complaint->user;
            $message = $request->message ?: $this->getDefaultMessage($request->status);
            
            // Stuur notificatie (email of in-app)
            Notification::send($user, new ComplaintStatusUpdated($complaint, $message));
            
            // Log de notificatie (optioneel)
            \Log::info("Status update notification sent to user {$user->id} for complaint {$complaint->id}");
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
}