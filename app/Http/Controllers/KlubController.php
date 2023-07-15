<?php

namespace App\Http\Controllers;

use App\Models\Klub;
use Illuminate\Http\Request;

class KlubController extends Controller
{
    public function create()
    {
        return view('klub.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:klubs',
            'kota' => 'required',
        ]);

        Klub::create([
            'nama' => $request->nama,
            'kota' => $request->kota,
        ]);

        return redirect()->back()->with('success', 'Data klub berhasil disimpan.');
    }
}
