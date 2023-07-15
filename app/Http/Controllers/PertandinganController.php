<?php

namespace App\Http\Controllers;

use App\Models\Klub;
use App\Models\Pertandingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PertandinganController extends Controller
{
    public function create()
    {
        $klubs = Klub::all();
        return view('pertandingan.create', compact('klubs'));
    }

    public function store(Request $request)
    {
        // Validasi form

        // Menyimpan data pertandingan satu per satu
        Pertandingan::create([
            'klub_id_1' => $request->klub_id_1,
            'klub_id_2' => $request->klub_id_2,
            'skor_1' => $request->skor_1,
            'skor_2' => $request->skor_2,
        ]);

        return redirect('/klasemen')->with('success', 'Data pertandingan berhasil disimpan.');
    }

    public function storeMultiple(Request $request)
    {
        $validatedData = $request->validate([
            'klub_id.*' => 'required|distinct',
            'skor_1.*' => 'required|integer',
            'skor_2.*' => 'required|integer',
        ]);

        $klub_ids = $validatedData['klub_id'];
        $skor_1s = $validatedData['skor_1'];
        $skor_2s = $validatedData['skor_2'];

        // Proses penyimpanan pertandingan multiple di sini

        // Misalnya:
        $count = count($klub_ids);
        for ($i = 0; $i < $count; $i++) {
            $pertandingan = new Pertandingan;
            $pertandingan->klub_id_1 = $klub_ids[$i];

            // Periksa apakah ada klub kedua yang tersedia
            if (isset($klub_ids[$i + 1])) {
                $pertandingan->klub_id_2 = $klub_ids[$i + 1];
            } else {
                $pertandingan->klub_id_2 = null; // Set klub_id_2 menjadi null jika tidak ada klub kedua
            }

            // Periksa apakah elemen array $skor_1s dan $skor_2s tersedia sebelum mengaksesnya
            if (isset($skor_1s[$i]) && isset($skor_2s[$i])) {
                $pertandingan->skor_1 = $skor_1s[$i];
                $pertandingan->skor_2 = $skor_2s[$i];
            } else {
                // Tangani jika elemen array tidak tersedia atau tidak sesuai
                $pertandingan->skor_1 = null;
                $pertandingan->skor_2 = null;
            }

            try {
                $pertandingan->save();
            } catch (\Exception $e) {
                // Tangani kesalahan saat menyimpan data
                return redirect('/klasemen')->with('error', 'Gagal menyimpan pertandingan. Error: ' . $e->getMessage());
            }
        }

        return redirect('/klasemen')->with('success', 'Pertandingan berhasil disimpan.');
    }


    public function showKlasemen()
    {
        $klubs = Klub::all();
        $klasemen = [];

        foreach ($klubs as $klub) {
            $main = Pertandingan::where(function ($query) use ($klub) {
                $query->where('klub_id_1', $klub->id)
                    ->orWhere('klub_id_2', $klub->id);
            })->sum(DB::raw('IF(klub_id_1 = ' . $klub->id . ' OR klub_id_2 = ' . $klub->id . ', 1, 0)'));


            $menang = Pertandingan::where(function ($query) use ($klub) {
                $query->where('klub_id_1', $klub->id)
                    ->where('skor_1', '>', 'skor_2');
            })->orWhere(function ($query) use ($klub) {
                $query->where('klub_id_2', $klub->id)
                    ->where('skor_2', '>', 'skor_1');
            })->count();

            $seri = Pertandingan::where(function ($query) use ($klub) {
                $query->where('klub_id_1', $klub->id)
                    ->where('skor_1', '=', 'skor_2');
            })->orWhere(function ($query) use ($klub) {
                $query->where('klub_id_2', $klub->id)
                    ->where('skor_2', '=', 'skor_1');
            })->whereColumn('skor_1', '=', 'skor_2')
                ->sum('skor_1');


            $kalah = Pertandingan::where(function ($query) use ($klub) {
                $query->where('klub_id_1', $klub->id)
                    ->whereRaw('skor_1 < skor_2');
            })->orWhere(function ($query) use ($klub) {
                $query->where('klub_id_2', $klub->id)
                    ->whereRaw('skor_2 < skor_1');
            })->count();


            $gol_menang = Pertandingan::where(function ($query) use ($klub) {
                $query->where('klub_id_1', $klub->id);
            })->orWhere(function ($query) use ($klub) {
                $query->where('klub_id_2', $klub->id);
            })->sum('skor_1');

            $gol_kalah = Pertandingan::where(function ($query) use ($klub) {
                $query->where('klub_id_1', '!=', $klub->id)
                    ->where('klub_id_2', $klub->id);
            })->orWhere(function ($query) use ($klub) {
                $query->where('klub_id_2', '!=', $klub->id)
                    ->where('klub_id_1', $klub->id);
            })->sum('skor_2');


            $point = ($menang * 3) + $seri;

            $klasemen[] = [
                'klub' => $klub,
                'main' => $main,
                'menang' => $menang,
                'seri' => $seri,
                'kalah' => $kalah,
                'gol_menang' => $gol_menang,
                'gol_kalah' => $gol_kalah,
                'point' => $point,
            ];
        }

        // Urutkan klasemen berdasarkan poin
        usort($klasemen, function ($a, $b) {
            return $b['point'] - $a['point'];
        });

        return view('/klasemen', compact('klasemen'));
    }
}
