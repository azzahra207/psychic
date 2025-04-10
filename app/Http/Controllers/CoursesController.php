<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class CoursesController extends Controller
{
    public function index(Request $request)
    {
        $model = \App\Models\Tipe::select('*');
        return view('courses.index', [
            'rows' => $model->get()
        ]);
    }
    public function show($id)
    {
        $majors=\App\Models\Jurusan::all();
        return view('courses.show', [
            'majors'=>$majors,
            'row' =>\App\Models\Tipe::where('id', $id)->first()
        ]);  
    }
    public function edit($id)
    {
        return view('courses.update', [
            'row' =>\App\Models\Tipe::where('id', $id)->first()
        ]);  
    }
    public function store(request $request )
    {
        $file = $request->file('files');
        $ekstensi = $file->getClientOriginalExtension();
        $tanggal = str_replace(['-',':',''],'',\Carbon\Carbon::now());
        $namaFile = 'gambar-'.$tanggal.'.'.$ekstensi;
        $file->move(public_path('img'), $namaFile);

        \App\Models\Tipe::create([
            'title' =>$request['title'],
            'content' =>$request['content'],
            'files' =>$namaFile,
        ]);
        return redirect()->to('/courses')->with('success','berhasil');
    }
    // public function update(request $request,$id )
    // {
        
    //     if($request->hasFile('files')) {
    //     $file = $request->file('files');
    //     $ekstensi = $file->getClientOriginalExtension();
    //     $tanggal = str_replace(['-',':',''],'',\Carbon\Carbon::now());
    //     $namaFile = 'gambar-'.$tanggal.'.'.$ekstensi;
    //     $file->move(public_path('img'), $namaFile);
    //     $data['files'] = $namaFile;
    //    }
    //    $data = [
    //     'title' =>$request['title'],
    //     'content' =>$request['content'],
    //     'files' =>$namaFile,
    //     'activated' =>$request['activated'],
    // ];
       
    //     \App\Models\Courses::where('id', $id)->update($data);

    //     return redirect()->to('courses');
            
            public function destroy($id)
            {
                $model = \App\Models\Courses::where('id', $id);
                $row =$model->first();
                \Illuminate\Support\Facades\File::delete(public_path('img/'.$row->files));
                $model->delete();
                return redirect()->to('courses');
            }

} 