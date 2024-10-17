<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DesaController extends Controller
{
    public function index(Request $request)
    {
        $nama_desa = $request->nama_desa;
        $query = Desa::query();
        $query->select('*');
        if (!empty($nama_desa)) {
            $query->where('nama_desa', 'like','%'.$nama_desa.'%');
        }
        $desa = $query->get();
        // $desa = DB::table('desa')->orderBy('kode_desa')->get();
        return view('desa.index', compact('desa'));
    }

    public function store(Request $request)
    {
        $kode_desa = $request->kode_desa;
        $nama_desa = $request->nama_desa;
        $data = [
            'kode_desa' => $kode_desa,
            'nama_desa' => $nama_desa,
        ];

        $simpan = DB::table('desa')->insert($data);
        if ($simpan) {
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan !']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan !']);
        }
    }

    public function edit(Request $request) 
    {
        $kode_desa = $request->kode_desa;
        $desa = DB::table('desa')->where('kode_desa',$kode_desa)->first();
        return view('desa.edit', compact('desa'));
    }

    public function update($kode_desa,Request $request)
    {
        $nama_desa = $request->nama_desa;
        $data = [
            'nama_desa' => $nama_desa,
        ];

        $update = DB::table('desa')->where('kode_desa',$kode_desa)->update($data);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update !']);
        }else{
            return Redirect::back()->with(['Warning' => 'Data Gagal Di Update !']);
        }
    }

    public function delete($kode_desa)
    {
        $hapus = DB::table('desa')->where('kode_desa', $kode_desa)->delete();
        if ($hapus) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus !']);
        }else{
            return Redirect::back()->with(['Warning' => 'Data Gagal Di Hapus !']);
        }
    }
}
