<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
   public function index() 
   // untuk menampilkan data siswa
   {
      $rows = \App\Models\Siswa::all();
    return view('siswa/index', compact('rows'));
   }
   public function create() //untuk menampilkan form tambah siswa
   {
    return view('siswa/create');
   }
   public function store(request $request)
   {
      \App\Models\Siswa::create($request->all());
      return redirect()->route('siswa');
   }
   public function show($id)
   {
    $siswa = \App\Models\Siswa::find($id);
    return view('siswa/view', compact('siswa'));
   }
   public function edit($id) //Menampilkan form ubah siswa
   {
      $siswa = \App\Models\Siswa::find($id);
      return view('siswa/update', compact('siswa'));
   }
   public function update(Request $request, $id) // Memperbarui data dari Form
   {
      $siswa = \App\Models\Siswa::find($id);
      $siswa->update($request->all());
      return redirect()->route('siswa');
   }
   public function destory($id) // menghapus data
   {
      $siswa = \App\Models\Siswa::find($id);
      $siswa->delete();
      return redirect()->route('siswa');
   }
   
}
