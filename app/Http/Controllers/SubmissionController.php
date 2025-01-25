<?php
namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $submissions = Submission::paginate($request->get('per_page', 16));
        return response()->json($submissions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:job_listings,id',
            'status' => 'sometimes|in:pending,accepted,rejected',
            'applied_at' => 'sometimes|date',
        ]);

        $submission = Submission::create($validated);

        return response()->json([
            'message' => 'Submission created successfully',
            'data' => $submission,
        ], 201);
    }

    public function show($id)
    {
        $submission = Submission::findOrFail($id);
        return response()->json([
            'message' => 'Submission retrieved successfully',
            'data' => $submission,
        ]);
    }

    public function updateSubmission(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'job_id' => 'sometimes|exists:job_listings,id',
            'status' => 'sometimes|in:pending,accepted,rejected',
            'applied_at' => 'sometimes|date',
        ]);

        $submission->update($validated);

        return response()->json([
            'message' => 'Submission updated successfully',
            'data' => $submission,
        ]);
    }

    public function destroy($id)
    {
        $submission = Submission::findOrFail($id);
        $submission->delete();

        return response()->json([
            'message' => 'Submission deleted successfully',
        ]);
    }
}