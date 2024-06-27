<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
  public function logout(Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
  }

  public function loginForm() {
    if (!Auth::check()) {
      return view('backend.auth.login');
    } else {
      return redirect()->route('dashboard');
    }
  }

  public function login(Request $request) {
    $request->validate([
      'email'    => 'required|string|email',
      'password' => 'required|string',
    ]);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
      return redirect()->route('dashboard');
    } else {
      return back()->with('fail', 'Invalid Credentials');
    }
  }

  /**
   * redirect route to login page
   *
   * @return void
   */
  public function domain() {
    return redirect()->route('login');
  }
}
