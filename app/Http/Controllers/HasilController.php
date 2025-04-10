<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HasilController extends Controller {
    
    public function result(Request $request)
    {
        \App\Models\HasilTes::where('user_id',auth()->user()->id)
        ->update([
            'status'=>'Selesai'
        ]);
        $tes_user = \App\Models\HasilTes::orderBy('created_at','desc')->where('user_id',auth()->user()->id)->first();

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
            \App\Models\HasilTes::orderBy('created_at','desc')->where('user_id',auth()->user()->id)->first()
            ->update([
                'tipe_id'=>$rankTipe[0],
                'hasil'=>(max($hasil) / $total) * 100
            ]);
            return view('result', [
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
     
}