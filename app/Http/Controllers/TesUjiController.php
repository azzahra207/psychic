<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TesUjiController extends Controller
{
    
  public function index() 
   
  {
    //  $rows = \App\Models\TesUji::all();
     $rows = \App\Models\TesUji::select('*')->where('id', 1)->get();
     $data =[
       'rows' => $rows
     ];
   return view('tesuji.soal', $data);

  }

  public function show(Request $request, $id)
    {   
        $tes_user = \App\Models\HasilTes::where('user_id',auth()->user()->id)->where('status','Belum')->first();
        if ($tes_user) {
            $answer=\App\Models\HasilTesDetail::where('hasil_tes_id',$tes_user->id)->where('soal_id',$id)->first();
            if ($request->has('pilgan')) { 
                session()->put('uji_ke'.$id, $request['pilgan']);
                $jawaban_id=$request['pilgan'];
            } else if($answer){
                $jawaban_id=$answer->jawaban_id;
            } else{
                $jawaban_id='kosong';
            }
        } else{
            $jawaban_id='kosong';
        }
        
        // cek dulu apakah ada sesi sebelumnya yg
        // jika belum ada sesi maka tambahkan baru
        // cek apakah soal yang tanpil dihalaman saat ini sudah ada di sesi yang baru (jika sebelumnya belum ikut sesi)
        
        $soalList = \App\Models\TesUji::where('id', $id)->first();
        $jawaban =\App\Models\Jawaban::where('soal_id',$id)->get();

        if (auth()->check()) { // jika pengguna pernah login
           
            $jawaban_user = session()->get('uji') ?? [];
            $process = \App\Models\HasilTes::where('user_id', auth()->user()->id)
                ->where('status', 'Belum')
                ->first();
            $finish = \App\Models\HasilTes::where('user_id', auth()->user()->id)
                ->where('status', 'Selesai')
                ->first();

            if ($process)  { //jika pengguna pernah mengerjakan tes ini sebelumnya namun belum selesai
                
                $chek_hasil_detail = \App\Models\HasilTesDetail::where('soal_id', $id)
                    ->where('hasil_tes_id', $process->id)
                    ->first();
                
                if($chek_hasil_detail) {
                    \App\Models\HasilTesDetail::where('soal_id', $id)
                        ->where('hasil_tes_id', $process->id)
                        ->update([
                            'jawaban_id' => $jawaban_id
                        ]);
                    } else {
                        \App\Models\HasilTesDetail::create([
                                'hasil_tes_id'=>$process->id,
                                'soal_id'=>$id,
                                'jawaban_id' => $jawaban_id
                            ]);
                        
                }
            }   
            
            else { // jika user belum pernah tes atau tes sebelumnya selesai
                \App\Models\HasilTes::create([ //membuat data baru dengan sesi 1
                    'hasil' =>0, // mengambil skor dari public function hasil(),  
                    'user_id' => auth()->user()->id, 
                    'tipe_id'=>0,
                    'sesi' => 1,    
                    'status' => 'Belum'           
                ]);
                foreach ($jawaban_user as $soal => $jawab) {
                        $hasilTes=\App\Models\HasilTes::where('user_id',auth()->user()->id)->where('status','Belum');
                        \App\Models\HasilTesDetail::create([
                            'hasil_tes_id' => $hasilTes->id,  
                            'soal_id' => $id,            
                            'jawaban_id' => $jawab        
                        ]);
                    }
              
                }

                }
                
                // dump(session()->all(),$soalList,$jawaban);
            $uji=\App\Models\HasilTes::where('user_id',auth()->user()->id)->where('status','Belum')->first();
            $model=\App\Models\HasilTesDetail::where('soal_id',$id)->where('hasil_tes_id',$uji->id); 
            $models=\App\Models\HasilTesDetail::where('hasil_tes_id',$uji->id); 
            
            return view('tesuji.show', [
                'id'=>$id,
                'model' => $model->get(),
                'models' => $models->get(),
                'row' => $soalList,
                'jawaban' => $jawaban,
                'soal_id' => $id,
                'jawaban_id' => $jawaban_id,
            ]);
            
    }
  public function save(Request $request, $id)
    {   
        $tes_user = \App\Models\HasilTes::where('user_id',auth()->user()->id)->where('status','Belum')->first();
        if ($tes_user) {
            $answer=\App\Models\HasilTesDetail::where('hasil_tes_id',$tes_user->id)->where('soal_id',$id)->first();
            if ($request->has('pilgan')) { 
                session()->put('uji_ke'.$id, $request['pilgan']);
                $jawaban_id=$request['pilgan'];
            } else if($answer){
                $jawaban_id=$answer->jawaban_id;
            } else{
                $jawaban_id='kosong';
            }
        } 
        
        // cek dulu apakah ada sesi sebelumnya yg
        // jika belum ada sesi maka tambahkan baru
        // cek apakah soal yang tanpil dihalaman saat ini sudah ada di sesi yang baru (jika sebelumnya belum ikut sesi)
        
        $soalList = \App\Models\TesUji::where('id', $id)->first();
        $jawaban =\App\Models\Jawaban::where('soal_id',$id)->get();

        if (auth()->check()) { // jika pengguna pernah login
           
            $jawaban_user = session()->get('uji') ?? [];
            $process = \App\Models\HasilTes::where('user_id', auth()->user()->id)
                ->where('status', 'Belum')
                ->first();
            $finish = \App\Models\HasilTes::where('user_id', auth()->user()->id)
                ->where('status', 'Selesai')
                ->first();

            if ($process)  { //jika pengguna pernah mengerjakan tes ini sebelumnya namun belum selesai
                
                $chek_hasil_detail = \App\Models\HasilTesDetail::where('soal_id', $id)
                    ->where('hasil_tes_id', $process->id)
                    ->first();
                
                if($chek_hasil_detail) {
                    \App\Models\HasilTesDetail::where('soal_id', $id)
                        ->where('hasil_tes_id', $process->id)
                        ->update([
                            'jawaban_id' => $jawaban_id
                        ]);
                    } else {
                        \App\Models\HasilTesDetail::create([
                                'hasil_tes_id'=>$process->id,
                                'soal_id'=>$id,
                                'jawaban_id' => $jawaban_id
                            ]);
                        
                }
            }   
            
            else { // jika user belum pernah tes atau tes sebelumnya selesai
                \App\Models\HasilTes::create([ //membuat data baru dengan sesi 1
                    'hasil' =>0, // mengambil skor dari public function hasil(),  
                    'user_id' => auth()->user()->id, 
                    'tipe_id'=>0,
                    'sesi' => 1,    
                    'status' => 'Belum'           
                ]);
                foreach ($jawaban_user as $soal => $jawab) {
                        $hasilTes=\App\Models\HasilTes::where('user_id',auth()->user()->id)->where('status','Belum');
                        \App\Models\HasilTesDetail::create([
                            'hasil_tes_id' => $hasilTes->id,  
                            'soal_id' => $id,            
                            'jawaban_id' => $jawab        
                        ]);
                    }
              
                }

                }
                
                // dump(session()->all(),$soalList,$jawaban);
            $uji=\App\Models\HasilTes::where('user_id',auth()->user()->id)->where('status','Belum')->first();
            $model=\App\Models\HasilTesDetail::where('soal_id',$id)->where('hasil_tes_id',$uji->id); 
            $models=\App\Models\HasilTesDetail::where('hasil_tes_id',$uji->id); 
            if ($id < 120) {
                $no=$id+1;
            } else {
                $no=$id; // Jika sudah selesai
            }
            
            return redirect()->to('/tesuji/'.$no);

            
    }
  
    public function create()
    {
        return view('tesuji.create');
    }
    public function edit($id)
    {
        return view('tesuji.update', [
            'row' =>\App\Models\TesUji::where('id', $id)->first()
        ]);  
    }
    public function editPilgan($id)
    {
        return view('tesuji.ubah', [
            'pilih' =>\App\Models\Jawaban::where('id', $id)->first()
        ]);  
    }
    public function store(request $request )
    {

        \App\Models\TesUji::create([
           'soal'=>$request['soal']
        ]);
        return redirect()->to('/tesuji')->with('success','berhasil');
    }
    public function storePilgan(request $request )
    {

        \App\Models\Jawaban::create([
           'jawaban'=>$request['jawaban']
        ]);
        return redirect()->to('/tesuji')->with('success','berhasil');
    }
    public function update(request $request,$id )
    {
       $data = [
        'soal'=>$request['soal']
    ];
    \App\Models\TesUji::where('id', $id)->update($data);

    return redirect()->to('tesuji/'.$id);
    }
    public function updatePilgan(Request $request, $id)
{

   \App\Models\Jawaban::where('id',$id)->update([
    'jawaban'=>$request['jawaban']
   ]);

    if($id<=240){
        if($id%4){
            $no=intdiv($id,4);
            $no++;
        } else{
            $no=intdiv($id,4);
        }
    } else {
        if($id%2){
            $no=intdiv($id,2)-59; // atau 60+(intdiv(($id-240),2)+1)
        } else{
            $no=intdiv($id,2)-60;
        }
    }

    return redirect()->to('tesuji/'.$no);
}

 
    public function detresult(Request $request, $id)
    {
        $tes_user = \App\Models\HasilTes::where('id',$id)->where('user_id',auth()->user()->id)->first();

        if (!$tes_user) {
            return redirect()->back()->with('error', 'Tidak ada jawaban yang disimpan.');
        }
        $huruf = \App\Models\Jawaban::pluck('huruf')->toArray();
        $nilai = \App\Models\Jawaban::pluck('nilai')->toArray();
        $tipe_id = \App\Models\Jawaban::pluck('tipe_id')->toArray();
        $tipeSatu = \App\Models\Jurusan::pluck('tipeSatu')->toArray();
        $tipeDua = \App\Models\Jurusan::pluck('tipeDua')->toArray();
        $tipeTiga = \App\Models\Jurusan::pluck('tipeTiga')->toArray(); 
        $idJurusan = \App\Models\Jurusan::pluck('id')->toArray(); 
        $icons=\App\Models\Tipe::pluck('icon')->toArray();
        $major = \App\Models\Jurusan::all();
        $type=\App\Models\Tipe::all();
        $hasil = [
            'Realistic' => 0,
            'Investigative' => 0,
            'Artistic' => 0,
            'Social' => 0,
            'Enterprising' => 0,
            'Conventional' => 0
        ];
        $RIASEC = [
            'Realistic' => 1,
            'Investigative' => 2,
            'Artistic' => 3,
            'Social' => 4,
            'Enterprising' => 5,
            'Conventional' => 6
        ];
        for ($i = 1; $i <= 60; $i++) {
            $index = ($i - 1) * 4;
            $tipe = $tipe_id[$index];
            // $huruf_user='A';
            $huruf_user = \App\Models\HasilTesDetail::where('hasil_tes_id',$tes_user->id)->where('soal_id',$i)->pluck('jawaban_id')->first();
            for ($j = 0; $j < 4; $j++) {
                if ($huruf_user == $huruf[$index + $j]) {
                    switch ($tipe) {
                        case 1:
                            $hasil['Realistic'] += $nilai[$index + $j];
                            break;
                        case 2:
                            $hasil['Investigative'] += $nilai[$index + $j];
                            break;
                            case 3:
                                $hasil['Artistic'] += $nilai[$index + $j];
                                break;
                                case 4:
                            $hasil['Social'] += $nilai[$index + $j];
                            break;
                            case 5:
                                $hasil['Enterprising'] += $nilai[$index + $j];

                            break;
                            default:
                            $hasil['Conventional'] += $nilai[$index + $j];
                            break;
                        }
                    }
                }
        }
        
        for ($i = 61; $i <= 120; $i++) {
            $index = 240 + ($i - 61) * 2;
            $huruf_user = \App\Models\HasilTesDetail::where('hasil_tes_id',$tes_user->id)->where('soal_id',$i)->pluck('jawaban_id')->first();
            // $huruf_user='A';
            for ($j = 0; $j <= 1; $j++) {
                if ($huruf_user == $huruf[$index + $j]) {
                    $tipe = $tipe_id[$index + $j];
                    switch ($tipe) {
                        case 1:
                            $hasil['Realistic'] += 1;
                            break;
                            case 2:
                                $hasil['Investigative'] += 1;
                                break;
                                case 3:
                                    $hasil['Artistic'] += 1;
                            break;
                        case 4:
                            $hasil['Social'] += 1;
                            break;
                            case 5:
                                $hasil['Enterprising'] += 1;
                            break;
                            default:
                            $hasil['Conventional'] += 1;
                            break;
                        }
                    }
                }
            }
            
            $total = array_sum($hasil);
            arsort($hasil); 
            $rankTipe = array_keys($hasil); 
            $jurusan = [
                'pertama' => [],
                'kedua' => [],
                'ketiga' => []
            ];
            foreach ($tipeSatu as $a => $tipe) {
                if ($tipe == $RIASEC[$rankTipe[0]]) {
                    $jurusan['pertama'][$a] = $idJurusan[$a];
                }
            }
            foreach ($tipeDua as $a => $tipe) {
                if ($tipe == $RIASEC[$rankTipe[1]]) {
                    $jurusan['kedua'][$a] = $idJurusan[$a];
                }
            }
    
            foreach ($tipeTiga as $a => $tipe) {
                if ($tipe == $RIASEC[$rankTipe[2]]) {
                    $jurusan['ketiga'][$a] = $idJurusan[$a];
                }
            }
            return view('tesuji.detresult', [
                'nilai'=>$nilai,
                'hasil' => $hasil,
                'total' => $total,
                'saran1' => $jurusan['pertama'],
                'saran2' => $jurusan['kedua'],
                'saran3' => $jurusan['ketiga'],
                'tipe1' => $rankTipe[0],
                'tipe2' => $rankTipe[1],
                'tipe3' => $rankTipe[2],
                'icon'=>$icons,
                'major' => $major,
                'type'=>$type
            ]);
        }
        public function dethistory(Request $request,$id){
            $details=\App\Models\HasilTesDetail::where('hasil_tes_id',$id)->where('jawaban_id','!=','kosong')->orderBy('soal_id','asc');
            $questions=\App\Models\Soal::all();
            $answers=\App\Models\Jawaban::all();
            return view('tesuji.dethistory',[
                'details'=>$details->get(),
                'questions'=>$questions,
                'answers'=>$answers
            ]
            );
        }

        
    }
    //     public function reset()
    // {
    //     $uji=session()->get('uji',[]);
    //     unset($uji['uji.ke_'.$id]);
    //     session()->put('uji',$uji);
    
    //     return redirect()->route('tesuji.show')->with('success', 'Jawaban telah direset.');
    // }
    
    // public function save() {
    //     $tipe=$this->    ; // mengambil return 'tipe1' dari fungsi hasil()
    //     $persentase=$this->hasil()number_format(max($hasil)/$total*100,2); // mengambil return 'hasil' dan 'total' dari fungsi hasil()
    //     $user=auth()->user()->id;
    //     \App\Models\HasilTes::create([
    
    //     ])
    // }