<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Guru;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Unique;

class DaftarAbsenController extends Controller
{

    public function index()
    {
        $kelas = user::where('role', 'guru')->get();
        return view('absen.daftar', compact('kelas'));
    }

    public function create($id)
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
        // $guru = kelas::where('guru_id', $id)->with('guru')->get();
        // $a = Absen::where('kelas_id', $id)->join('siswa', 'siswa.id', '=', 'siswa_id')->get();
        $guru = user::where('role', 'guru')->where('kelas_id', $id)->get();
        // $a = absen::where('kelas_id', $id)->join('users', 'users.id', '=', 'siswa_id')->get('name');
        // $a = absen::where('kelas_id', $id)->join('users', 'users.id', '=', 'siswa_id')->get('name');
        // $b = absen::where('kelas_id', $id)->join('users', 'users.id', '=', 'siswa_id')->get();
        // $a = user::where('role', 'siswa')->where('kelas_id', $id)->get();
        // return $a;
        // $a = absen::where('kelas_id', $id)->join('users', 'users.id', '=', 'siswa_id')->get('status');
        // $b = $a->unique('name');
        // return $b;

        $coba = user::where('role', 'siswa')->where('kelas_id', $id)->with('absen')->get();
        foreach ($coba as $c) {
            $stats[] = [
                $c->name,
                $kls = $c->kelas_id,
                $sts = $c->absen,
            ];
        }
        // return $kls;
        $today = today();
        $dates = [];
        for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
            $d[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
            $hari[] = Carbon::createFromDate($today->year, $today->month, $i)->format('D');
            $m = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('m');
            $y = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y');
            // eak
        }

        $wow = [$d,$hari];
        // return $wow;

        foreach ($coba as $cok) {
            $awikwok[] = [$cok->absen];
        }


        $bulan = today()->format('Y-m-d');
        $start = carbon::parse($bulan)->startOfMonth();
        $end= carbon::parse($bulan)->endOfMonth();
        $weekday= CarbonPeriod::between($start,$end)->filter('isWeekday');
        $weekend= CarbonPeriod::between($start,$end)->filter('isWeekend');
        // return $weekend;
        foreach($weekday as $p){
            $wd[] = $p->format('d');
        }
        foreach($weekend as $p){
            $wn[] = $p->format('d');
        }
        // return $d;
        // return $wn;
        $days = [$wd,$wn];
        return view('absen.listtanggal', compact('days','wn','d', 'm', 'y', 'guru', 'coba', 'kls','hari','wow'));
        // return view('absenkelas', compact('t', 'guru', 'a'));
    }

    public function surat()
    {
        // return true;
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