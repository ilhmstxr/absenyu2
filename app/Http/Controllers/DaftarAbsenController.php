<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Guru;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Unique;

class DaftarAbsenController extends Controller
{

    public function index()
    {
        $kelas = Kelas::with('guru')->get();
        $guru = guru::all();
        // return $kelas;
        return view('absen.daftar', compact('kelas', 'guru'));
    }

    public function create($id)
    {

    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
        $guru = kelas::where('guru_id', $id)->with('guru')->get();
        // $a = Absen::where('kelas_id', $id)->get();
        // $nb = absen::where('kelas_id', $id)->get();
        // $ns = Siswa::where('kelas_id', $id)->with('absen')->get();
        // $a = absen::where('siswa_id', $id)->with('siswa')->get();
        $siswa = Absen::where('kelas_id',$id)
        ->join('siswa', 'siswa.id', '=', 'siswa_id')
        ->get();
        // return $siswa;
        $nama = [];
        foreach ($siswa as $s ) {
            $nama[] = $s->nama;
            
        }
        $ua = array_unique($nama);
        
        $status= [];
        foreach ($siswa as $s ) {
            $status[] = [$s->siswa_id,$s->status];
        }
        // return true;
        $us = array_unique($status);
        // return $status;
        
        
        // return $ua;

        $tgl = [];
        foreach ($siswa as $date) {
            $tgl[] = $date->tanggal ;
        }
        $t = array_unique($tgl);

        
        return view('absen.listtanggal', compact('t', 'guru', 'siswa', 'ua', 'status'));
        // return view('absenkelas', compact('t', 'guru', 'a'));
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}


   
        // tanggal 1 bulan di bulan itu
        // $today = today();
        // $a ='First day : ' . date("Y-m-01", strtotime($today)) . ' - Last day : ' . date("Y-m-t", strtotime($today));
        // $awal = date('y-m-01',strtotime($today));
        // $akhir = date('t',strtotime($today)); 
        // $range = [];
        // for ($i = 1;$i<= $akhir; $i++ ){
        //     $range[]= $i;
        // }
        // return $range;