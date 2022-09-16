<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class PasswordController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('passwords.edit',compact('user'));
    }
    public function updatepassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('dashboard');
    }
}
