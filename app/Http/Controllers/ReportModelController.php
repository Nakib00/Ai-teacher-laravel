<?php

namespace App\Http\Controllers;

use App\Models\ReportModel;
use Illuminate\Http\Request;

class ReportModelController extends Controller
{
    // Add Report
    public function addReport(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'topic_id' => 'required|integer',
            'teacher_id' => 'nullable|integer',
            'note' => 'nullable|string',
            'interaction_points' => 'nullable|integer',
            'answer_points' => 'nullable|integer',
            'time_points' => 'nullable|integer',
            'discussion_points' => 'nullable|integer',
            'total_points' => 'nullable|integer',
            'is_active' => 'boolean',
            'session_started_at' => 'nullable',
            'session_ended_at' => 'nullable',
            'feedback' => 'nullable|string',
        ]);

        $report = ReportModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Report added successfully',
            'data' => $report
        ]);
    }

    // Get All Reports
    public function getAllReport()
    {
        $reports = ReportModel::with(['user', 'topic', 'teacher'])->get();
        return response()->json([
            'status' => true,
            'data' => $reports
        ]);
    }

    // Get Reports by User ID
    public function getReportByUser($user_id)
    {
        $reports = ReportModel::with(['user', 'topic', 'teacher'])
                    ->where('user_id', $user_id)
                    ->get();

        return response()->json([
            'status' => true,
            'data' => $reports
        ]);
    }

    // Update Report
    public function updateReport(Request $request, $id)
    {
        $report = ReportModel::find($id);
        if (!$report) {
            return response()->json([
                'status' => false,
                'message' => 'Report not found'
            ], 404);
        }

        $report->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Report updated successfully',
            'data' => $report
        ]);
    }

    // Delete Report
    public function deleteReport($id)
    {
        $report = ReportModel::find($id);
        if (!$report) {
            return response()->json([
                'status' => false,
                'message' => 'Report not found'
            ], 404);
        }

        $report->delete();

        return response()->json([
            'status' => true,
            'message' => 'Report deleted successfully'
        ]);
    }
}
