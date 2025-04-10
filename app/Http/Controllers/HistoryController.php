<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class HistoryController extends Controller
{
    
    public function history(Request $request)
    {
        $model = \App\Models\HasilTes::where('user_id',auth()->user()->id)->orderBy('created_at','desc');
        return view('history', [
            'rows' => $model->get()
        ]);
    }
}