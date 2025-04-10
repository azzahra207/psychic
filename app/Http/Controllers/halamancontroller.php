<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class halamancontroller extends Controller
{
    public function lihat(){
        return view('lihat');
    }
    
    public function uji()
    {
        return view('uji');
    }
    public function uji2()
    {
        return view('uji2');
    }
    public function info()
    {
        return view('info');
    }
    public function welcome()
    {
        return view('welcome');
    }
    public function login()
    {
        return view('login');
    }
    public function register() {
        return view('register');
    }
   
    public function hallo() {
        return view('hallo');
    }
    public function hasil() {
        return view('hasil');
    }
    public function campus() {
        return view('campus');
    }
    public function detcampus() {
        return view('detcampus');
    }
    public function jurusan() {
        return view('jurusan');
    }
    public function detjurusan() {
        return view('detjurusan');
    }
    public function ujian() {
        return view('ujian');
    }
    public function karir() {
        return view('karir');
    }
    public function detkarir() {
        return view('detkarir');
    }
   
    
}