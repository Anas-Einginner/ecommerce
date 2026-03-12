<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InfoController extends Controller
{
         public function view()
    {   
            $contact = ContactInfo::first();
        return view('dashboard.info-messages.info.index',compact('contact'));
    }



public function update(Request $request)
{
    $request->validate([
        'phone' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email'],
        'support_email' => ['required', 'email'],
        'facebook' => ['nullable', 'string', 'max:255'],
        'instagram' => ['nullable', 'string', 'max:255'],
        'twitter' => ['nullable', 'string', 'max:255'],
        'pinterest' => ['nullable', 'string', 'max:255'],
    ]);

    $data = $request->only([
        'phone',
        'email',
        'support_email',
        'facebook',
        'instagram',
        'twitter',
        'pinterest'
    ]);

    // أضف https تلقائياً إذا غير موجود
    foreach (['facebook','instagram','twitter','pinterest'] as $field) {
        if (!empty($data[$field]) && !str_starts_with($data[$field], 'http')) {
            $data[$field] = 'https://' . $data[$field];
        }
    }

    ContactInfo::updateOrCreate(['id' => 1], $data);

    return response()->json([
        'success' => 'تم تعديل معلومات الاتصال بنجاح'
    ]);
}

    // public function active(Request $request)
    // {
    //     $category = Category::findOrFail($request->id);

    //     $category->update([
    //         'status' => 'active'
    //     ]);

    //     return response()->json([
    //         'success' => 'تمت العملية بنجاح'
    //     ]);
    // }

    // public function inactive(Request $request)
    // {
    //     $category = Category::findOrFail($request->id);

    //     $category->update([
    //         'status' => 'inactive'
    //     ]);

    //     return response()->json([
    //         'success' => 'تمت العملية بنجاح'
    //     ]);
    // }










    // public function delete(Request $request)
    // {
    //     $category = Category::findOrFail($request->id);

    //     // لو عندك صورة احذفها
    //     if ($category->image && Storage::disk('public')->exists($category->image)) {
    //         Storage::disk('public')->delete($category->image);
    //     }

    //     $category->delete();

    //     return response()->json([
    //         'success' => 'تمت العملية بنجاح'
    //     ]);
    // }
}
