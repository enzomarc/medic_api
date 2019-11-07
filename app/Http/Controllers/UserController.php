<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	/**
	 * Get all users list.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index()
	{
		$users = User::all();
		return response()->json(['users' => $users]);
	}
	
	/**
	 * Get user with given id.
	 *
	 * @param int $user
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(int $user)
	{
		try {
			$user = User::findOrFail($user);
			return response()->json(['user' => $user]);
		} catch (Exception $e) {
			return response()->json(['message' => "Unable to find user.", 'exception' => $e->getMessage()], 500);
		}
	}
	
	/**
	 * Create a new user.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Validation\ValidationException
	 * @throws \Throwable
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'first_name' => 'required',
			'phone' => 'required',
			'password' => 'required',
		]);
		
		$data = $request->except('_token');
		$data['password'] = Hash::make($data['password']);
		
		try {
			$user = new User($data);
			$user->saveOrFail();
			
			return response()->json(['message' => "User created successfully.", 'user' => $user], 201);
		} catch (Exception $e) {
			return response()->json(['message' => "An error occurred during user creation.", 'exception' => $e->getMessage()], 500);
		}
	}
	
	/**
	 * Update the given user.
	 *
	 * @param Request $request
	 * @param int $user
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Request $request, int $user)
	{
		$user = User::find($user);
		$data = $request->except('_token');
		
		if (isset($data['password']))
			$data['password'] = Hash::make($data['password']);
		
		try {
			$user->update($data);
			return response()->json(['message' => "User updated successfully.", 'user' => $user]);
		} catch (Exception $e) {
			return response()->json(['message' => "An error occurred during user update.", 'exception' => $e->getMessage()], 500);
		}
	}
	
	/**
	 * Delete the given user.
	 *
	 * @param int $user
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(int $user)
	{
		try {
			$user = User::find($user);
			$user->delete();
			
			return response()->json(['message' => "User deleted successfully."]);
		} catch (Exception $e) {
			return response()->json(['message' => "An error occurred during user deletion.", 'exception' => $e->getMessage()], 500);
		}
	}
}
