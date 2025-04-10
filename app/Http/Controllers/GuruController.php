<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
   public function index() 
   
   {
      $rows = \App\Models\Guru::all();
      $data =[
        'rows' => $rows
      ];
    return view('guru.index', $data);

   }
   public function create()
   {
    return view('guru.create');
   }
   public function store(request $request)
   {
    \App\Models\Guru::create([
      'NamaGuru' => $request['NamaGuru'],
      'Alamat' => $request['Alamat'],
      'HP' => $request['HP'],
    ]);
    return redirect()->to('/guru')->with('succes','berhasil');
   }
   public function edit($id)
   {
    $row = \App\Models\Guru::where('ID','=',$id)->first();
    return view('guru.update',['row'=>$row]);
   }
   public function update(Request $request, $id)
   {
    \App\Models\Guru::where('ID','=',$id)
    ->update([
        'NamaGuru' => $request['NamaGuru'],
        'Alamat' => $request['Alamat'],
        'HP' => $request['HP'],
    ]);
    return redirect()->to('/guru')->with('succes','berhasil');
   }
   public function destroy($id)
   {
    \App\Models\Guru::find($id)->delete();
    return redirect()->to('/guru')->with('success','Berhasil dihapus');
   }
}