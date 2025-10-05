<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use App\Models\Driver;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the complaints.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complaints = Complaint::with(['user', 'driver', 'order'])->latest()->paginate(10);
        return view('admin.complaints.index', compact('complaints'));
    }

 
    /**
     * Display the specified complaint.
     *
     * @param  \App\Models\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function show(Complaint $complaint)
    {
        $complaint->load(['user', 'driver', 'order']);
        return view('admin.complaints.show', compact('complaint'));
    }

   

    /**
     * Update complaint status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, Complaint $complaint)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:1,2,3',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $complaint->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => __('messages.Status_Updated_Successfully'),
            'status_label' => $complaint->status_label,
            'status_badge' => $complaint->status_badge
        ]);
    }

    /**
     * Remove the specified complaint from storage.
     *
     * @param  \App\Models\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complaint $complaint)
    {
        $complaint->delete();

        return redirect()->route('admin.complaints.index')
            ->with('success', __('messages.Complaint_Deleted_Successfully'));
    }
}