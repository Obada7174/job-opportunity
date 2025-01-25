<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\JobListing;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function index(Request $request)
    {
        $jobListings = JobListing::paginate($request->get('per_page', 16));
        return response()->json($jobListings);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|numeric',
            'location' => 'required|string|in:remote,in_company|max:255',
            'working_hours' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $jobListing = JobListing::create($validated);

        return response()->json([
            'message' => 'Job listing created successfully',
            'data' => $jobListing,
        ], 201);
    }

    public function show($id)
    {
        $jobListing = JobListing::findOrFail($id);
        return response()->json([
            'message' => 'Job listing retrieved successfully',
            'data' => $jobListing,
        ]);
    }

    public function updateJob(Request $request, $id)
    {
        $jobListing = JobListing::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'salary' => 'sometimes|numeric',
            'location' => 'sometimes|string|max:255',
            'working_hours' => 'sometimes|string|max:255',
            'experience' => 'sometimes|string|max:255',
            'job_title' => 'sometimes|string|max:255',
            'company_id' => 'sometimes|exists:companies,id',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        $jobListing->update($validated);

        return response()->json([
            'message' => 'Job listing updated successfully',
            'data' => $jobListing,
        ]);
    }

    public function destroy($id)
    {
        $jobListing = JobListing::findOrFail($id);
        $jobListing->delete();

        return response()->json([
            'message' => 'Job listing deleted successfully',
        ]);
    }

    public function getRecommendedJobs($userId, Request $request)
{
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $userSkills = $user->skills()->pluck('skills.id');

    if ($userSkills->isEmpty()) {
        return response()->json(['message' => 'User has no skills'], 400);
    }

    $perPage = $request->get('per_page', 16);
    
    $recommendedJobs = JobListing::whereHas('skills', function ($query) use ($userSkills) {
        $query->whereIn('skills.id', $userSkills);
    })->paginate($perPage);

    return response()->json([
        'user_id' => $user->id,
        'recommended_jobs' => $recommendedJobs,
    ]);
}

}