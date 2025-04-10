<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class CampusController extends Controller
{
    
    public function index(Request $request)
    {
        $model = \App\Models\Campus::orderBy('title','asc');
        if (isset($request['nama'])) {
            $model->where('title', 'Like', '%'.$request['nama'].'%');
        }
        return view('campus.index', [
            'rows' => $model->paginate(20)
        ]);
    }
    public function create()
    {
        return view('campus.create');
    }
    public function show($id)
    {
        return view('campus.show', [
            'row' =>\App\Models\Campus::where('id', $id)->first()
        ]);  
    }
    public function edit($id)
    {
        return view('campus.update', [
            'row' =>\App\Models\Campus::where('id', $id)->first()
        ]);  
    }
    public function store(request $request )
    {
        $file = $request->file('files');
        $ekstensi = $file->getClientOriginalExtension();
        $tanggal = str_replace(['-',':',''],'',\Carbon\Carbon::now());
        $namaFile = 'gedung-'.$tanggal.'.'.$ekstensi;
        $file->move(public_path('img'), $namaFile);
        
        $logo = $request->file('logo');
        $ekstensi = $logo->getClientOriginalExtension();
        $namalogo = 'logo-'.$tanggal.'.'.$ekstensi;
        $logo->move(public_path('img'), $namalogo);

        \App\Models\Campus::create([
            'title' =>$request['title'],
            'content' =>$request['content'],
            'files' =>$namaFile,
            'logo'=>$namalogo,
            'status' =>$request['status'],
            'biaya'=>$request['biaya'],
            'lokasi'=>$request['lokasi'],
            'profil'=>$request['profil'],
            'alamat'=>$request['alamat'],
            'akreditasi'=>$request['akreditasi'],
            'website'=>$request['website'],
            'dayaTampung'=>$request['dayaTampung']
        ]);
        return redirect()->to('/campus')->with('success','berhasil');
    }
    public function update(request $request,$id )
    {
        
        if($request->hasFile('files')) {
        $file = $request->file('files');
        $ekstensi = $file->getClientOriginalExtension();
        $tanggal = str_replace(['-',':',''],'',\Carbon\Carbon::now());
        $namaFile = 'gedung-'.$tanggal.'.'.$ekstensi;
        $file->move(public_path('img'), $namaFile);
        $data['files'] = $namaFile;

        $logo = $request->file('logo');
        $ekstensi = $logo->getClientOriginalExtension();
        $namalogo = 'logo-'.$tanggal.'.'.$ekstensi;
        $logo->move(public_path('img'), $namalogo);
        $data['logo'] = $namalogo;
       }
       $data = [
        'title' =>$request['title'],
        'content' =>$request['content'],
        'files' =>$namaFile,
        'logo'=>$namalogo,
        'status' =>$request['status'],
        'biaya'=>$request['biaya'],
        'lokasi'=>$request['lokasi'],
        'profil'=>$request['profil'],
        'alamat'=>$request['alamat'],
        'akreditasi'=>$request['akreditasi'],
        'website'=>$request['website'],
        'dayaTampung'=>$request['dayaTampung']
    ];
       
        \App\Models\Campus::where('id', $id)->update($data);

        return redirect()->to('campus');
            }
            public function destroy($id)
            {
                $model = \App\Models\Campus::where('id', $id);
                $row =$model->first();
                \Illuminate\Support\Facades\File::delete(public_path('img/'.$row->files));
                $model->delete();
                return redirect()->to('campus');
            }

}