<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('admin.settings.profile');
    }

    public function update(Request $request): JsonResponse
    {
        $user = User::find($request->id);

        // === UPLOAD FOTO PROFIL ===
        if ($request->hasFile('image')) {

            // Hapus foto lama jika ada
            if ($user->image && Storage::disk('public')->exists('profile/' . $user->image)) {
                Storage::disk('public')->delete('profile/' . $user->image);
            }

            // Simpan foto baru
            $image = $request->file('image');
            $filename = $image->hashName();  
            $image->storeAs('public/profile', $filename);

            // Simpan nama file ke database
            $user->image = $filename;
        }

        // === UPDATE PASSWORD (jika diisi) ===
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        // === UPDATE NAMA ===
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        // === UPDATE USERNAME ===
        if ($request->has('username')) {
            $user->username = $request->username;
        }

        // Simpan ke database
        if (!$user->save()) {
            return response()->json(["message" => __("data failed to change")], 400);
        }

        return response()->json(["message" => __("data changed successfully")], 200);
    }
}
 