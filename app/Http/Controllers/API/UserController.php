<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        return new UserResource(Auth::user()->load('roles'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        \Log::info('Request data:', [
            'name' => $request->input('name'),
            'has_file' => $request->hasFile('avatar'),
            'all_data' => $request->all()
        ]);

        if ($request->name) {
            $user->name = $request->input('name');
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => new UserResource($user->fresh())
        ]);
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();

            if ($user->avatar !== null) {
                Storage::disk('public')->delete($user->avatar);
            }

            return response()->json([
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error when deleting user:', [
                'error_message' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Error when deleting user'
            ], 500);
        }
    }
}
