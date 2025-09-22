<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

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
        return view('admin.dashboard', compact('recentComplaints', 'totalComplaints', 'newComplaints', 'resolvedComplaints'));
    }

    public function complaints(Request $request)
    {
        $query = Complaint::query();

        // البحث حسب ID
        if ($request->has('search')) {
            $query->where('id', $request->search);
        }

        // التصفية حسب الحالة
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $complaints = $query->latest()->paginate(10);

        return view('admin.complaints', compact('complaints'));
    }

    public function showComplaint($id)
    {
        $complaint = Complaint::findOrFail($id);
        return view('admin.complaint-details', compact('complaint'));
    }

    public function deleteComplaint($id)
    {
        $complaint = Complaint::findOrFail($id);
        
        // حذف الصورة إذا كانت موجودة
        if ($complaint->photo_path) {
            Storage::disk('public')->delete($complaint->photo_path);
        }
        
        $complaint->delete();

        return redirect()->route('admin.complaints')->with('success', 'Klacht succesvol verwijderd.');
    }
}