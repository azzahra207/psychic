<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class JurusanController extends Controller
{
    
    public function index(Request $request)
    {
        $types=\App\Models\Tipe::select('*');
        $model = \App\Models\Jurusan::orderBy('title','asc')->select('*');
        if (isset($request['nama'])) {
            $model=\App\Models\Jurusan::orderBy('title','asc')->where('title', 'Like', '%'.$request['nama'].'%');
        }
        if (isset($request['tipe'])) {
            if($request['tipe']!=7){
                $model=\App\Models\Jurusan::orderBy('title','asc')->where('tipeSatu',$request['tipe']);
            }
        }
        return view('jurusan.index', [
            'rows' => $model->paginate(20),
            'types'=>$types->get()
        ]);
    }
    

   
    public function create()
    {
        return view('jurusan.create');
    }
    public function show($id)
    {
       
        return view('jurusan.show', [
            'row' =>\App\Models\Jurusan::where('id', $id)->first()
        ]);  
    }
    public function edit($id)
    {
        return view('jurusan.update', [
            'row' =>\App\Models\Jurusan::where('id', $id)->first()
        ]);  
    }
    public function store(request $request )
    {
        $file = $request->file('files');
        $ekstensi = $file->getClientOriginalExtension();
        $tanggal = str_replace(['-',':',''],'',\Carbon\Carbon::now());
        $namaFile = 'gambar-'.$tanggal.'.'.$ekstensi;
        $file->move(public_path('img'), $namaFile);

        \App\Models\Jurusan::create([
            'title' =>$request['title'],
            'content' =>$request['content'],
            'files' =>$namaFile,
            'tipeSatu' =>$request['tipeSatu'],
            'tipeDua' =>$request['tipeDua'],
            'tipeTiga' =>$request['tipeTiga'],
        ]);
        return redirect()->to('/jurusan')->with('success','berhasil');
    }
    public function update(request $request,$id )
    {
        
        if($request->hasFile('files')) {
        $file = $request->file('files');
        $ekstensi = $file->getClientOriginalExtension();
        $tanggal = str_replace(['-',':',''],'',\Carbon\Carbon::now());
        $namaFile = 'gambar-'.$tanggal.'.'.$ekstensi;
        $file->move(public_path('img'), $namaFile);
        $data['files'] = $namaFile;
       }
       $data = [
        'title' =>$request['title'],
        'content' =>$request['content'],
        'files' =>$namaFile,
        'activated' =>$request['activated'],
    ];
       
        \App\Models\Jurusan::where('id', $id)->update($data);

        return redirect()->to('jurusan');
    }
            public function destroy($id)
            {
                $model = \App\Models\Jurusan::where('id', $id);
                $row =$model->first();
                \Illuminate\Support\Facades\File::delete(public_path('img/'.$row->files));
                $model->delete();
                return redirect()->to('jurusan');
            }

}