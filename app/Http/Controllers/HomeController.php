<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function index(Request $request)
    {
    $model = \App\Models\Jurusan::select('*');
    $campus=\App\Models\Campus::select('*');
    $odel = \App\Models\Testimoni::orderBy('updated_at','desc');
    if (isset($request['nama'])) {
        $model->where('title', 'Like', '%'.$request['nama'].'%');
        $odel->where('title', 'Like', '%'.$request['nama'].'%');
    }
    return view('home', [
        'rows' => $model->get(),
        'tes' => $odel->get(),
        'campus'=> $campus->get()
    ]);}
    // public function indexTestimoni(Request $request)
    // {
    // $model = \App\Models\Testimoni::select('*');
    // if (isset($request['nama'])) {
    //     $model->where('title', 'Like', '%'.$request['nama'].'%');
    // }
    // return view('home', [
        
    // ]);}
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // // public function __construct()
    // // {
    // //     // $this->middleware('auth');
    // // }

    // /**
    //  * Show the application dashboard.
    //  *
    //  * @return \Illuminate\Contracts\Support\Renderable
    //  */
    // public function index()
    // {
    //     return view('home');
    // }
}
