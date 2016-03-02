<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function display()
    {
        return view('login');
    }

    public function validation()
    {
        $email = Input::get('email');
        $password = Input::get('password');

        $agency = DB::table('agency')->where('email',$email)->first();
        $errors = 'Invalid username or password!';
        if($agency)
        {
            if(!strcmp($agency->password,$password))
            {
                Auth::loginUsingId($agency->id);
                return Auth::user();
            }   
        }
        return redirect()->back()->withErrors($errors);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
