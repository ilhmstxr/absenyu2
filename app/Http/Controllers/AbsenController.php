<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\User;
use App\Models\tanggal;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = kelas::all();
        // return $kelas;
        return view('absen.absen', compact('kelas'));
    }

    public function tanggal(request $request)
    {

        for ($i = 0; $i < count($request->siswa); $i++) {

            $check = Absen::where(['id' => $request->siswa[$i], 'id' => $request->kelas, 'tanggal' => Carbon::now('Asia/Jakarta')->format('Y-m-d')])->get();
            if (count($check) == 0 && $request->status[$i] != "Hadir") {
                $absen = new Absen;
                $absen->id = $request->siswa[$i];
                $absen->id = $request->kelas;
                $absen->tanggal = Carbon::now('Asia/Jakarta')->format('Y-m-d');
                $absen->status = $request->status[$i];
                $absen->keterangan = $request->status[$i];
                $absen->save();

                // Session::flash('berhasil', 'Selamat!!! Data Anda Berhasil Diupdate');
                // return redirect('listkelas');
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $d = [
            'siswa_id' => $request->siswa_id,
            'status' => $request->status,
        ];
        $stat = $request->status;
        $k = $request->kelas_id;
        $kelas = array_unique($k);
        $kel = implode($kelas);
        // return $kel;


        // tgl hari ini
        $today = today()->format('Y-m-d');
        // store seluruh siswa dalam sekelas
        for ($i = 0; $i < count($d['siswa_id']); $i++) {
            $d[] =
                absen::insert([
                    'tanggal' => $today,
                    // 'tanggal' => $request->tanggal,
                    'kelas_id'=>$kel,
                    'siswa_id' => $d['siswa_id'][$i],
                    'status' => $d['status'][$i],
                ]);
        }

        // jika ada yang sakit / izin maka setelah upload lgsg redirect ke up surat

        if (in_array("sakit", $stat)) {
            return redirect(route('surat.edit', $kelas));
        } elseif (in_array("izin", $stat)) {
            return redirect(route('surat.edit', $kelas));
        } else {
            return redirect('absen')->with('status', 'kelas anda telah diabsen!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guru = user::where('role', 'guru')->where('kelas_id', $id)->get();
        $siswa = user::where('role', 'siswa')->where('kelas_id', $id)->get();
        $total = user::where('role', 'siswa')->where('kelas_id', $id)->count();

        $today = today()->format("Y-m-d");
        // $absen = absen::where('kelas_id', $id)->orderby('tanggal', 'desc')->first('tanggal');
        // $absen = user::where('role', 'siswa')->where('kelas_id', $id)->orderby('tanggal', 'desc')->first('tanggal');
        // $absen = user::where('role', 'siswa')->where('kelas_id', $id)->with('absen')->first();

        $s = user::where('role', 'siswa')->where('kelas_id', $id)->first();
        $absen = absen::where('siswa_id', $s->id)->orderby('tanggal', 'desc')->first();
        // return $absen;
        if ($absen == null) {
            return view('absen.absenkelas', compact('siswa', 'guru', 'total'));
        }
        // if ($absen->tanggal == $today) {
        //     return redirect()->back()->with('absen', 'Sudah Melakukan Absensi');
        // }
        else{

            return view('absen.absenkelas', compact('siswa', 'guru', 'total'));
        }
        
        // return view('absen.absenkelas', compact('siswa', 'guru', 'total'));
    }

    public function listabsen($id)
    {
        $guru = kelas::where('guru_id', $id)->with('guru')->get();
        $siswa = siswa::where('kelas_id', $id)->get();
        $total = siswa::where('kelas_id', $id)->count();
        return $guru;
        return view('absen.listabsen', compact('siswa', 'guru', 'total'));
    }


    public function list($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function surat()
    {
        $a = absen::where('status', 'izin')->get();
        $s = absen::where('status', 'sakit')->get();
        return view('absen.uploadsurat', compact('a', 's'));
        // return $a;
    }

    public function cari(Request $request)
	{
		// menangkap data pencarian
		$cari = $request->cari;
 
    		// mengambil data dari table pegawai sesuai pencarian data
		$user = DB::table('user')
		->where('name','like',"%".$cari."%");
 
    		// mengirim data pegawai ke view index
            
		return view('absen.listtanggal',['user' => $cari], compact('user'));
 
	}
}
