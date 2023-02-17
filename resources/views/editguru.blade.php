@extends('layout.admin')
@section('title', 'Data Siswa')
@section('content-title', 'edit guru')
@section('content')

    <div class="card-body">
        <form method="post" action="{{ route('guru.store') }}">
            @csrf

            @foreach ($guru as $g)
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name='nama'
                        value="{{ $g->name }}">
                </div>
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="text" class="form-control" id="nip" name='nip'
                        value="{{ $g->nomor_induk}}">
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="form-select form-control" id="jenis_kelamin" name='jenis_kelamin'
                        value="{{ $g->jenis_kelamin}}">
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            @endforeach

            <div class="card-footer">
                <a href="{{ route('guru.index') }}"type="button" class="btn btn-danger">Batal</a>
                <input type="submit" class="btn btn-success" value="Simpan">
            </div>
        </form>
    </div>

@endsection
