<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Storage;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $Companies = Company::paginate($request->get('per_page', 16));
        return response()->json($Companies);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'company_capacity' => 'required|string|max:255',
            'working_hours' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
        ]);
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('companies', 'public');
            $validated['image'] = $path; 
        }
    
        $company = Company::create($validated);
    
        return response()->json([
            'message' => 'company created successfully',
            'company' => $company,
            'image' => $company->image ,
            'category_id'=>$company->category_id 
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::findOrFail($id);
    
        $company->image = $company->image ? asset('storage/' . $company->image) : null;
    
        return response()->json($company);
    }

  
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // تحقق من البيانات المرسلة
        dd($request->all());
    
        $company = Company::findOrFail($id);
    
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'company_capacity' => 'sometimes|string|max:255',
            'working_hours' => 'sometimes|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('image')) {
            if ($company->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($company->image);
            }
            $path = $request->file('image')->store('companies', 'public');
            $validated['image'] = $path;
        }
    
        $company->update($validated);
    
        return response()->json([
            'message' => 'Company updated successfully',
            'company' => $company,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $company = Company::findOrFail($id);
    if ($company->image) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($company->image);
    }
    $company->jobListings()->delete();
    $company->delete();
    return response()->json([
        'message' => 'Company deleted successfully',
    ]);
}
}
