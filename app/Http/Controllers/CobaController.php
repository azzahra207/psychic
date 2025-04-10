<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CobaController extends Controller
{
   public function index() 
   
   {
      $rows = \App\Models\Coba::all();
      $data =[
        'rows' => $rows
      ];
    return view('coba.index', $data);

   }
   public function create()
   {
    return view('coba.create');
   }
   public function store(request $request)
   {
    \App\Models\Coba::create([
      'CobaCoba' => $request['CobaCoba'],
      'Tes' => $request['Tes'],
      'Berhasil' => $request['Berhasil'],
    ]);
    return redirect()->to('/coba')->with('succes','berhasil');
   }
   public function edit($id)
   {
    $row = \App\Models\Coba::where('ID','=',$id)->first();
    return view('coba.update',['row'=>$row]);
   }
   public function update(Request $request, $id)
   {
    \App\Models\Coba::where('ID','=',$id)
    ->update([
      'CobaCoba'=> $request ['CobaCoba'],
      'Tes'=> $request ['Tes'],
      'Berhasil'=> $request ['Berhasil'],
    ]);
    return redirect()->to('/coba')->with('succes','berhasil');
   }
   public function destroy($id)
   {
    \App\Models\Coba::find($id)->delete();
    return redirect()->to('/coba')->with('success','Berhasil dihapus');
   }
}