<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $rows = User::all();
        $mine = User::where('id', auth()->user()->id)->first();

        return view('users.index', compact('rows', 'mine'));
    }
    public function deleteProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        // Periksa apakah tombol hapus ditekan
        if ($request->input('profil') === 'hapus') {
            $user->update(['profil' => 'akun.png']);
        }
    
        return redirect()->route('users.index')->with('success', 'Profil berhasil dihapus');
    }
    
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $profil = $request->file('profil');
        $fotoProfil = $profil 
            ? 'profil-' . str_replace(['-', ':', ''], '', \Carbon\Carbon::now()) . '.' . $profil->getClientOriginalExtension()
            : 'akun.png';

        if ($profil) {
            $profil->move(public_path('img'), $fotoProfil);
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'profil' => $fotoProfil
        ]);

        return redirect()->route('users.index')->with('success', 'Berhasil');
    }

    public function edit($id)
    {
        $row = User::findOrFail($id);
        return view('users.update', compact('row'));
    }

    public function view($id)
    {
        $row = User::findOrFail($id);
        return view('users.view', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $fileProfil = $user->profil;

        if ($request->input('profil') === 'hapus') {
            $fileProfil = 'akun.png';
        } elseif ($request->hasFile('profil')) {
            $profil = $request->file('profil');
            $fileProfil = 'profil-' . str_replace(['-', ':', ''], '', \Carbon\Carbon::now()) . '.' . $profil->getClientOriginalExtension();
            $profil->move(public_path('img'), $fileProfil);
        }

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            // 'password' => $request->filled('password') ? Hash::make($request->input('password')) : $user->password,
            'profil' => $fileProfil
        ]);

        return redirect()->route('users.index')->with('success', 'Berhasil');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('home')->with('success', 'Berhasil dihapus');
    }
}
