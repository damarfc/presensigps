<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = date("Y-m-d");
        $bulanini = date("m") * 1; //1ataujanuria
        $tahunini = date("Y"); //2024
        $PD_ID = Auth::guard('perangkat_desa')->user()->PD_ID;
        $presensihariini = DB::table('presensi')->where('PD_ID', $PD_ID)->where('tgl_presensi',$hariini)->first();
        $historibulanini = DB::table('presensi')
        ->where('PD_ID',$PD_ID)
        ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')
        ->orderBy('tgl_presensi')
        ->get();  
        
        $rekappresensi = DB::table('presensi')
        ->selectRaw('COUNT(PD_ID) as jmlhadir, SUM(IF(jam_in >= "08:00",1,0)) as jmlterlambat')
        ->where('PD_ID',$PD_ID)->where('PD_ID',$PD_ID)
        ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')
        ->first();
        
        $leaderboard = DB::table('presensi')
        ->join('perangkat_desa', 'presensi.PD_ID', '=', 'perangkat_desa.PD_ID')
        ->where('tgl_presensi', $hariini)
        ->orderBy('jam_in',)
        ->get();

        $namabulan = ["","Januari","Febuari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        
        $rekapizin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')
        ->where('PD_ID', $PD_ID)
        ->whereRaw('MONTH(tgl_izin)="' . $bulanini . '"')
        ->whereRaw('YEAR(tgl_izin)="'.$tahunini.'"')
        ->where('status_approved', 1)
        ->first();

        return view('dashboard.dashboard',compact('presensihariini', 'historibulanini', 'namabulan', 'bulanini', 'tahunini', 'rekappresensi', 'leaderboard', 'rekapizin'));
    }

    public function dashboardadmin() 
    {
        $hariini = date("Y-m-d");
        $rekappresensi = DB::table('presensi')
        ->selectRaw('COUNT(PD_ID) as jmlhadir, SUM(IF(jam_in >= "08:00",1,0)) as jmlterlambat')
        ->where('tgl_presensi', $hariini)
        ->first();

        $rekapizin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')
        ->where('tgl_izin', $hariini)
        ->where('status_approved', 1)
        ->first();
        return view('dashboard.dashboardadmin', compact('rekappresensi', 'rekapizin'));
    }
}
