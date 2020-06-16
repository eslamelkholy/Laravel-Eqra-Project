<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\updatePasswordValidation;
use Illuminate\Support\Facades\Hash;

class updatePasswordController extends Controller
{
    public function update(updatePasswordValidation $request)
    {
        $request->user()->fill([
            'password' => Hash::make($request->newPassword)
        ])->save();
        return response()->json([
            'msg'=>"password updated successfully"
        ]);
    }
}
