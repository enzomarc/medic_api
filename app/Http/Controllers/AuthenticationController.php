<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
	/**
	 * Login user with the given credentials.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function login(Request $request)
	{
		$this->validate($request, [
			'phone' => 'required',
			'password' => 'required',
		]);
		
		$credentials = $request->only(['phone', 'password']);
		$user = User::all()->where('phone', $credentials['phone'])->first();
		
		if ($user != null) {
			if (Hash::check($credentials['password'], $user->password)) {
				return response()->json(['message' => "User successfully logged in.", 'user' => $user]);
			} else {
				return response()->json(['message' => "Phone number or password is incorrect."], 401);
			}
		} else {
			return response()->json(['message' => "Phone number or password is incorrect."], 401);
		}
	}
}
