<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPasswordRequest;


class UserController extends Controller
{
    public function updatePassword(UserPasswordRequest $request)
    {
        return response()->json(User::findOrFail(Auth::user()->id)->update([
            'password' => Hash::make($request->get('password'))
        ]), 200);
    }
}
