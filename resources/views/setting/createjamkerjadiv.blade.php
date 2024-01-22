@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <h2 class="page-title">
            Setting Jam Kerja Divisi
          </h2>
        </div>
      </div>
    </div>
  </div>

{{-- Halaman Data Karyawan --}}
<div class="page-body">
    <div class="container-xl">
        <form action="/setting/jamkerjadiv/store" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="row mb-1">
                        <div class="col-6">
                            <div class="form-group">
                                <select name="kode_anper" id="kode_anper" class="form-select">
                                    <option value="">Pilih Mode Kerja</option>
                                    @foreach ($anper as $a )
                                    <option value="{{ $a->kode_anper }}">{{ strtoupper($a->nama_anper) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="kode_div" id="kode_div" class="form-select">
                                    <option value="">Pilih Divisi</option>
                                    @foreach ($divisi as $d)
                                    <option value="{{ $d->kode_div }}">{{ $d->nama_div }}</option>
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
                            <tr>
                                <td>
                                    Senin
                                    <input type="hidden" name="hari[]" value="Senin">
                                </td>
                                <td>
                                    <select name="kode_jamkerja[]" id="kode_jamkerja" class="form-select" required>
                                        <option value="">Pilih Jam Kerja</option>
                                        @foreach ($jamkerja as $d)
                                        <option value="{{ $d->kode_jamkerja }}">{{ $d->nama_jamkerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Selasa
                                    <input type="hidden" name="hari[]" value="Selasa">
                                </td>
                                <td>
                                    <select name="kode_jamkerja[]" id="kode_jamkerja" class="form-select" required>
                                        <option value="">Pilih Jam Kerja</option>
                                        @foreach ($jamkerja as $d)
                                        <option value="{{ $d->kode_jamkerja }}">{{ $d->nama_jamkerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Rabu
                                    <input type="hidden" name="hari[]" value="Rabu">
                                </td>
                                <td>
                                    <select name="kode_jamkerja[]" id="kode_jamkerja" class="form-select" required>
                                        <option value="">Pilih Jam Kerja</option>
                                        @foreach ($jamkerja as $d)
                                        <option value="{{ $d->kode_jamkerja }}">{{ $d->nama_jamkerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Kamis
                                    <input type="hidden" name="hari[]" value="Kamis">
                                </td>
                                <td>
                                    <select name="kode_jamkerja[]" id="kode_jamkerja" class="form-select" required>
                                        <option value="">Pilih Jam Kerja</option>
                                        @foreach ($jamkerja as $d)
                                        <option value="{{ $d->kode_jamkerja }}">{{ $d->nama_jamkerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Jumat
                                    <input type="hidden" name="hari[]" value="Jumat">
                                </td>
                                <td>
                                    <select name="kode_jamkerja[]" id="kode_jamkerja" class="form-select" required>
                                        <option value="">Pilih Jam Kerja</option>
                                        @foreach ($jamkerja as $d)
                                        <option value="{{ $d->kode_jamkerja }}">{{ $d->nama_jamkerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Sabtu
                                    <input type="hidden" name="hari[]" value="Sabtu">
                                </td>
                                <td>
                                    <select name="kode_jamkerja[]" id="kode_jamkerja" class="form-select" required>
                                        <option value="">Pilih Jam Kerja</option>
                                        @foreach ($jamkerja as $d)
                                        <option value="{{ $d->kode_jamkerja }}">{{ $d->nama_jamkerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Minggu
                                    <input type="hidden" name="hari[]" value="Minggu">
                                </td>
                                <td>
                                    <select name="kode_jamkerja[]" id="kode_jamkerja" class="form-select" required>
                                        <option value="">Pilih Jam Kerja</option>
                                        @foreach ($jamkerja as $d)
                                        <option value="{{ $d->kode_jamkerja }}">{{ $d->nama_jamkerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
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
