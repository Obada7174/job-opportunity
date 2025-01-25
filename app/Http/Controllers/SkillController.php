<?php
namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    // عرض جميع المهارات
    public function index(Request $request)
    {
        $skill = Skill::paginate($request->get('per_page', 16));
        return response()->json($skill);
    }

    // إنشاء مهارة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:skills,name',
        ]);

        $skill = Skill::create($request->only('name'));
        return response()->json($skill, 201);
    }

    // عرض مهارة محددة
    public function show($id)
    {
        $skill = Skill::findOrFail($id);
        return response()->json($skill);
    }

    // تحديث مهارة محددة
    public function update(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);

        $request->validate([
            'name' => 'required|string|unique:skills,name,' . $skill->id,
        ]);

        $skill->update($request->only('name'));
        return response()->json($skill);
    }

    // حذف مهارة محددة
    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);
        $skill->delete();
        return response()->json(['message' => 'skill deleted successfully']);
    }
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2',
        ]);

        $query = $request->input('query');

        $skills = Skill::where('name', 'LIKE', "%{$query}%")->get(['id', 'name']);

        return response()->json($skills);
    }
}