<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ChangePasswordController extends Controller
{
    public function index() {
        //TODO: adjust render page
        return Inertia::render('Auth/ChangePassword');
    }

    public function update() {
        $request = request()->validate([
            'currentPassword' => ['required', new MatchOldPassword],
            'newPassword' => ['required'],
            'newConfirmPassword' => ['same:newPassword'],
        ]);

        Auth::user()->fill([
            'password' => Hash::make($request['newPassword'])
        ])->save();

        
        return redirect()->route('changePassword.index')->with('successMessage', 'Password berhasil di ganti !!');
    }
}
