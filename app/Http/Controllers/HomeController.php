<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function index()
    {
        return view('home',[
            'title' => 'TDH Online: Homepage'
        ]);
    }

    public function profile($id)
    {
        $user = Session::get('user');
        if($user->id==$id)
            return redirect('/');

        $data = User::find($id);
        return view('profile',[
            'title' => "$data->fname $data->lname",
            'data' => $data,
            'person' => $data
        ]);
    }
}
