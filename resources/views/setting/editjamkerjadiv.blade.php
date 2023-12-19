@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <h2 class="page-title">
            Edit Jam Kerja Divisi
          </h2>
        </div>
      </div>
    </div>
  </div>

{{-- Halaman Data Karyawan --}}
<div class="page-body">
    <div class="container-xl">
        <form action="/setting/jamkerjadiv/{{ $jamkerjadiv->kode_jk_div }}/update" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="row mb-1">
                        <div class="col-6">
                            <div class="form-group">
                                <select name="kode_anper" id="kode_anper" class="form-select" disabled>
                                    <option value="">Pilih Anak Perusahaan</option>
                                    @foreach ($anper as $a )
                                    <option {{ $jamkerjadiv->kode_anper == $a->kode_anper ? 'selected' : ''}} value="{{ $a->kode_anper }}">{{ strtoupper($a->nama_anper) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="kode_div" id="kode_div" class="form-select" disabled>
                                    <option value="">Pilih Divisi</option>
                                    @foreach ($divisi as $d)
                                    <option {{ $jamkerjadiv->kode_div == $d->kode_div ? 'selected' : ''}} value="{{ $d->kode_div }}">{{ strtoupper($d->nama_div) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam Kerja</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jamkerjadiv_detail as $s )
                            <tr>
                                <td>
                                    {{ $s->hari }}
                                    <input type="hidden" name="hari[]" value="{{ $s->hari }}">
                                </td>
                                <td>
                                    <select name="kode_jamkerja[]" id="kode_jamkerja" class="form-select">
                                        <option value="">Pilih Jam Kerja</option>
                                        @foreach ($jamkerja as $d)
                                        <option {{ $d->kode_jamkerja == $s->kode_jamkerja ? 'selected' : '' }} value="{{ $d->kode_jamkerja }}">{{ $d->nama_jamkerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button class="btn btn-primary w-100" type="submit">Simpan</button>
                </div>
                <div class="col-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="6"> Master Jam Kerja</th>
                            </tr>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Awal Masuk</th>
                                <th>Jam Masuk</th>
                                <th>Akhir Masuk</th>
                                <th>Jam Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jamkerja as $d )
                            <tr>
                                <td>{{ $d->kode_jamkerja }}</td>
                                <td>{{ $d->nama_jamkerja }}</td>
                                <td>{{ $d->awal_jam_masuk }}</td>
                                <td>{{ $d->jam_masuk }}</td>
                                <td>{{ $d->akhir_jam_masuk }}</td>
                                <td>{{ $d->jam_pulang}}</td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
