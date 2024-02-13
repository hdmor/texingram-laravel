<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        return Inertia::render('Profile/Index', [
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
            'profile' => new UserResource($user)
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateImage(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $data = $request->validate([
                'avatar' => ['image', 'mimes:png,jpg,jpeg', 'nullable'],
                'cover' => ['image', 'mimes:png,jpg,jpeg', 'nullable']
            ]);
            $avatar = $request->file('avatar') ?? null;
            $cover = $request->file('cover') ?? null;

            if ($avatar) {
                if ($user->avatar_path) Storage::disk('public')->delete($user->avatar_path);
                $user->update(['avatar_path' => $avatar->store("avatars/user-{$user->getAuthIdentifier()}", 'public')]);
            }
            if ($cover) {
                if ($user->cover_path) Storage::disk('public')->delete($user->cover_path);
                $user->update(['cover_path' => $cover->store("covers/user-{$user->getAuthIdentifier()}", 'public')]);
            }

//            session('success', 'cover image has been updated successfully.');
            return back()->with('status', 'update-image');
        } else return Inertia::render(abort(403));
    }
}
