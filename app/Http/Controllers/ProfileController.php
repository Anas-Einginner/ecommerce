<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function view(Request $request): View
    {
        return view('dashboard.profiles.index', [
            'user' => $request->user(),
            'profile' => $request->profile,
            'editMode' => $request->boolean('edit'), 
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        // dd($request->all());
        $user = $request->user();

        // ✅ 1) Validation (CUSTOM)
        $validated = $request->validate([
            // users table
            'name'          => ['required','string','max:255'],
            'email'         => ['required','email','max:255','unique:users,email,' . $user->id],
            'phone'         => ['nullable','string','max:30'],
            'date_of_birth' => ['nullable','date'],
            'gender'        => ['nullable','in:m,fm'],

            // profiles table
            'dob'     => ['nullable','date'],
            'city'    => ['nullable','string','max:255'],
            'address' => ['nullable','string','max:255'],
            'bio'     => ['nullable','string'],
            'image'   => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        // ✅ 2) Update users fields
        $user->name          = $validated['name'];
        $user->email         = $validated['email'];
        $user->phone         = $validated['phone'] ?? null;
        $user->date_of_birth = $validated['date_of_birth'] ?? null;
        $user->gender        = $validated['gender'] ?? null;

        // لو الايميل تغيّر: رجّعي التوثيق null (اختياري)
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // ✅ 3) Prepare profile data
        $profileData = [
            'city'    => $validated['city'] ?? null,
            'address' => $validated['address'] ?? null,
            'bio'     => $validated['bio'] ?? null,
        ];

        // ✅ 4) Upload image (if exists)
        if ($request->hasFile('image')) {

            // مهم: php artisan storage:link
            $currentProfile = $user->profile;

            if ($currentProfile?->image) {
                Storage::disk('public')->delete($currentProfile->image);
            }

            $profileData['image'] = $request->file('image')->store('profiles', 'public');
        }

        // ✅ 5) Update/Create profile row
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return Redirect::route('dash.profile.view')
            ->with('success', 'تم تحديث الملف الشخصي بنجاح.');


    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
