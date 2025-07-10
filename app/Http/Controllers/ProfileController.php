<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    
    public function show(Request $request): View 
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }
    public function partialsProfileInfo(Request $request): View
    {
        return view('profile.partials.update-profile-information-form', [
            'user' => $request->user()
        ]);
    }
    public function partialsPassword(Request $request): View
    {
        return view('profile.partials.update-password-form', [
            'user' => $request->user()
        ]);
    }
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:6048',
        ]);
        $user->fill($request->validated());

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Redirect kembali ke halaman show dengan pesan sukses
        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }
}