<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
  public function profile($id)
{
    $user = User::with('blogComments')->findOrFail($id);

    return view('frontend.user.profile', compact('user'));
}
}
