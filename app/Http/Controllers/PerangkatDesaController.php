<?php

namespace App\Http\Controllers;

use App\Models\PerangkatDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PerangkatDesaController extends Controller
{
    public function index(Request $request)
    {

        $query = PerangkatDesa::query();
        $query->select('perangkat_desa.*','nama_desa');
        $query->join('desa','perangkat_desa.kode_desa', '=', 'desa.kode_desa');
        $query->orderBy('nama_lengkap');
        if(!empty($request->nama_perangkatdesa)){
            $query->where('nama_lengkap','like','%'.$request->nama_perangkatdesa.'%');
        }

        if(!empty($request->kode_desa)){
            $query->where('perangkat_desa.kode_desa', $request->kode_desa);
        }
        $perangkatdesa = $query->paginate(5);

        $desa = DB::table('desa')->get();
        return view('PerangkatDesa.index', compact('perangkatdesa','desa'));
    }

    public function store(Request $request) 
    {
        $PD_ID = $request->PD_ID;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_desa = $request->kode_desa;
        $password = Hash::make('12345');
        if($request->hasFile('foto')){
            $foto = $PD_ID.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = null;
        }

        try {
            $data = [
                'PD_ID' => $PD_ID,
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'jabatan' => $jabatan,
                'kode_desa' => $kode_desa,
                'foto' => $foto,
                'password' => $password,
            ];
            $simpan = DB::table('perangkat_desa')->insert($data);
            if ($simpan) {
                if($request->hasFile('foto')){
                    $folderPath = "public/uploads/perangkatdesa/";
                    $request->file('foto')->storeAs($folderPath,$foto); 
                }
                return Redirect::back()->with(['success'=>'Data Berhasil Disimpan !']);
            }
        } catch (\Exception $e) {
            // dd($e);
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan !']);
        }
    }

    public function edit(Request $request) 
    {
        $PD_ID = $request->PD_ID;
        $desa = DB::table('desa')->get();
        $perangkatdesa = DB::table('perangkat_desa')->where('PD_ID', $PD_ID)->first();
        return view('PerangkatDesa.edit',compact('desa','perangkatdesa'));
    }

    public function update($PD_ID, Request $request) 
    {
        $PD_ID = $request->PD_ID;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_desa = $request->kode_desa;
        $password = Hash::make('12345');
        $old_foto = $request->old_foto;
        if($request->hasFile('foto')){
            $foto = $PD_ID.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = $old_foto;
        }

        try {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'jabatan' => $jabatan,
                'kode_desa' => $kode_desa,
                'foto' => $foto,
                'password' => $password,
            ];
            $update = DB::table('perangkat_desa')->where('PD_ID',$PD_ID)->update($data);
            if ($update) {
                if($request->hasFile('foto')){
                    $folderPath = "public/uploads/perangkatdesa/";
                    $folderPathOld = "public/uploads/perangkatdesa/".$old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath,$foto); 
                }
                return Redirect::back()->with(['success'=>'Data Berhasil Diubah !']);
            }
        } catch (\Exception $e) {
            // dd($e);
            return Redirect::back()->with(['warning' => 'Data Gagal Diubah !']);
        }
    }

    public function delete($PD_ID)   
    {
        $delete = DB::table('perangkat_desa')->where('PD_ID',$PD_ID)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasi Di Hapus !']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal Di Hapus !']);
        }
    }

}
