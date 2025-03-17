<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            // Correcting the typo in accessing the user type
            $usertype = Auth::user()->usertype;

            if ($usertype == 'user') {
                return view('userAccount.index');
            } elseif ($usertype == 'admin') {
                return view('dashboard');
            } else {
                return redirect()->back();
            }
        } else {
            // If user is not logged in, you can redirect them to the login page or handle accordingly
            return redirect()->route('login');
        }
    }
}
