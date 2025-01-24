<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::paginate($request->get('per_page', 16));
    
        // تعديل الصور لكل المستخدمين في المجموعة
        $users->getCollection()->transform(function ($user) {
            if (isset($user->image)) { // تحقق من وجود الصورة
                $user->image = $user->image ? asset('storage/' . $user->image) : null;
            }
            return $user;
        });
    
        return response()->json($users);
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
    
        // تعديل رابط الصورة إذا وُجدت
        $user->image = $user->image ? asset('storage/' . $user->image) : null;
    
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $defaultImage = 'default_images/default_user.png'; // المسار الافتراضي للصورة
    
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'phone_number' => 'nullable|string|max:15|unique:users,phone_number,' . $user->id, // تأكد من أن الحقل هو phone_number وليس phoneNumber
            'last_name' => 'nullable|string|max:255',
            'role' => 'nullable|in:user,admin,company_owner',
            'skills' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // تأكيد أن image صورة
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // يسمح بتحميل ملفات PDF أو Word بحجم أقصى 2MB
            'certificates' => 'nullable|string',
            'languages' => 'nullable|string',
            'portfolio_url' => 'nullable|string|max:255',
            'presentation' => 'nullable|string',
            'experience' => 'nullable|string',
            'location' => 'nullable|string|max:255',
        ]);
    
        // تحديث الصورة إذا تم رفع صورة جديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا لم تكن الصورة الافتراضية
            if ($user->image && $user->image !== $defaultImage) {
                Storage::disk('public')->delete($user->image);
            }
    
            // حفظ الصورة الجديدة
            $path = $request->file('image')->store('users', 'public');
            $validated['image'] = $path;
        }
    
        // تحديث ملف السيرة الذاتية إذا تم رفع ملف جديد
        if ($request->hasFile('cv_file')) {
            // حذف ملف السيرة الذاتية القديم إذا كان موجودًا
            if ($user->cv_file_path) {
                Storage::disk('public')->delete($user->cv_file_path);
            }
    
            // حفظ الملف الجديد
            $cvFilePath = $request->file('cv_file')->store('cv', 'public');
            $validated['cv_file_path'] = $cvFilePath;
        }
    
        // تحديث كلمة المرور إذا تم إرسالها
        if (isset($validated['password']) && !empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']); // إزالة الحقل إذا كان فارغًا
        }
    
        // تحديث بيانات المستخدم
        $user->update($validated);
    
        return response()->json([
            'message' => 'User updated successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'image' => $user->image ? asset('storage/' . $user->image) : asset('storage/' . $defaultImage), // إنشاء رابط للصورة
                'cv_file_path' => $user->cv_file_path ? asset('storage/' . $user->cv_file_path) : null, // إنشاء رابط لملف السيرة الذاتية
            ],
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // حذف الصورة إذا وُجدت
        if ($user->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
