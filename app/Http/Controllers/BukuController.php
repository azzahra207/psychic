<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
   public function index() 
   
   {
      $rows = \App\Models\Buku::all();
      $data =[
        'rows' => $rows
      ];
    return view('buku.index', $data);

   }
   public function create()
   {
    return view('buku.create');
   }
   public function store(request $request)
   {
    \App\Models\Buku::create([
      'Judul' => $request['Judul'],
      'Penerbit' => $request['Penerbit'],
      'Pengarang' => $request['Pengarang'],
      'Tahun' => $request['Tahun'],
      'Sinopsis' => $request['Sinopsis'],
      'Jumlah' => $request['Jumlah'],
    ]);
    return redirect()->to('/buku')->with('success','berhasil');
   }
   public function edit($id)
   {
    $row = \App\Models\Buku::where('ID','=',$id)->first();
    return view('buku.update',['row'=>$row]);
   }
   public function update(Request $request, $id)
   {
    \App\Models\Buku::where('ID','=',$id)
    ->update([
        'Judul' => $request['Judul'],
      'Penerbit' => $request['Penerbit'],
      'Pengarang' => $request['Pengarang'],
      'Tahun' => $request['Tahun'],
      'Sinopsis' => $request['Sinopsis'],
      'Jumlah' => $request['Jumlah'],
    ]);
    return redirect()->to('/buku')->with('success','berhasil');
   }
   public function destroy($id)
   {
    \App\Models\Buku::find($id)->delete();
    return redirect()->to('/buku')->with('success','Berhasil dihapus');
   }
}