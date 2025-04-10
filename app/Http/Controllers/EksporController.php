<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\HasilTes;
use Illuminate\Http\Request;

class EksporController extends Controller
{
    public function ekspor()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $user = auth()->user(); 
        $hasilTes = HasilTes::where('user_id', auth()->user()->id)->orderBy('created_at','desc')
        ->where('status','Selesai')->get();
        if (!$hasilTes) {
            return redirect()->back()->with('error', 'Hasil tes tidak ditemukan!');
        }
        $types=\App\Models\Tipe::all();
        $majors=\App\Models\Jurusan::all();
        $pdf = Pdf::loadView('hasilTesPDF', compact('user', 'hasilTes','majors','types'));
        return $pdf->download('hasil-tes-' . $user->name . '.pdf');
    }
}
