<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
   public function index() 
   
   {
      $rows = \App\Models\MataPelajaran::all();
      $data =[
        'rows' => $rows
      ];
    return view('matapelajaran.index', $data);

   }
   public function create()
   {
    return view('matapelajaran.create');
   }
   public function store(request $request)
   {
    \App\Models\MataPelajaran::create([
      'Jurusan' => $request['Jurusan'],
      'MataPelajaran' => $request['MataPelajaran'],
      'SKS' => $request['SKS'],
    ]);
    return redirect()->to('/mapel')->with('succes','berhasil');
   }
   public function edit($id)
   {
    $row = \App\Models\MataPelajaran::where('ID','=',$id)->first();
    return view('matapelajaran.update',['row'=>$row]);
   }
   public function update(Request $request, $id)
   {
    \App\Models\MataPelajaran::where('ID','=',$id)
    ->update([
      'MataPelajaran'=> $request ['MataPelajaran'],
      'Jurusan'=> $request ['Jurusan'],
      'SKS'=> $request ['SKS'],
    ]);
    return redirect()->to('/mapel')->with('succes','berhasil');
   }
   public function destroy($id)
   {
    \App\Models\MataPelajaran::find($id)->delete();
    return redirect()->to('/mapel')->with('success','Berhasil dihapus');
   }
}