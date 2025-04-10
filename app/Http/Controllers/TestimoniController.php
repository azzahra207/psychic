<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class TestimoniController extends Controller
{
    
    public function index(Request $request)
    {
        $model = \App\Models\Testimoni::orderBy('updated_at','desc');
        if (isset($request['nama'])) {
            $model->where('title', 'Like', '%'.$request['nama'].'%');
        }
        return view('testimoni.index', [
            'rows' => $model->get(),
        ]);
    }

   
    public function create()
    {
        return view('testimoni.create');
    }
    public function show($id)
    {
       
        return view('testimoni.show', [
            'row' =>\App\Models\Testimoni::where('id', $id)->first()
        ]);  
    }
    public function edit($id)
    {
        return view('testimoni.update', [
            'row' =>\App\Models\Testimoni::where('id', $id)->first()
        ]);  
    }
    public function store(request $request )
    {
        if (auth()->check()){
            \App\Models\Testimoni::create([
                'title' =>auth()->user()->name,
                'content' =>$request['content'],
                'files' =>auth()->user()->profil,
                'Alamat'=>$request['Alamat']
            ]);
            return redirect()->to('/home')->with('success','berhasil');
        } else {

            $file = $request->file('files');
            $ekstensi = $file->getClientOriginalExtension();
            $tanggal = str_replace(['-',':',''],'',\Carbon\Carbon::now());
            $namaFile = 'gambar-'.$tanggal.'.'.$ekstensi;
            $file->move(public_path('img'), $namaFile);
            \App\Models\Testimoni::create([
                'title' =>$request['title'],
                'content' =>$request['content'],
                'files' =>$namaFile,
                'Alamat'=>$request['Alamat']
            ]);
            return redirect()->to('/home')->with('success','berhasil');
        }

    }
    // public function update(request $request,$id )
    // {
        
    // //     if($request->hasFile('files')) {
    // //     $file = $request->file('files');
    // //     $ekstensi = $file->getClientOriginalExtension();
    // //     $tanggal = str_replace(['-',':',''],'',\Carbon\Carbon::now());
    // //     $namaFile = 'gambar-'.$tanggal.'.'.$ekstensi;
    // //     $file->move(public_path('img'), $namaFile);
    // //     $data['files'] = $namaFile;
    // //    }
    //    $data = [
    //     'title' =>$request['title'],
    //     'content' =>$request['content'],
    //     'files' =>auth()->user()->profil,
    //     'activated' =>$request['activated'],
    //     'Alamat'=>$request['Alamat']
    // ];
       
    //     \App\Models\Testimoni::where('id', $id)->update($data);

    //     return redirect()->to('home');
            
            public function destroy($id)
            {
                $model = \App\Models\Testimoni::where('id', $id);
                $row =$model->first();
                \Illuminate\Support\Facades\File::delete(public_path('img/'.$row->files));
                $model->delete();
                return redirect()->to('testimoni');
            }

}