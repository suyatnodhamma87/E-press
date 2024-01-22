@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">
            Jam Kerja Karyawan
          </h2>
        </div>
      </div>
    </div>
</div>
{{-- Halaman SETTING JAM KERJA --}}
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                @if (Session::get('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                                @endif

                                @if (Session::get('warning'))
                                <div class="alert alert-warning">
                                    {{ Session::get('warning') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="#" class="btn btn-primary" id="btntambahjamker">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    Tambah Data
                                </a>
                            </div>
                        </div>
                        <div class="row mt-2"> {{-- Tabel data anak perusahaan --}}
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr style="text-align: center">
                                            <th style="text-align: center">No</th>
                                            <th>Kode Jam Kerja</th>
                                            <th>Nama Jam Kerja</th>
                                            <th>Awal Jam Masuk</th>
                                            <th>Jam Masuk</th>
                                            <th>Akhir Jam Masuk</th>
                                            <th>Awal Pulang</th>
                                            <th>Lokasi Kerja</th>
                                            <th>Radius (m)</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jamkerja as $j)
                                        <tr>
                                            <td> {{ $loop->iteration }}</td>
                                            <td>{{ $j->kode_jamkerja }}</td>
                                            <td>{{ $j->nama_jamkerja }}</td>
                                            <td>{{ $j->awal_jam_masuk }}</td>
                                            <td>{{ $j->jam_masuk }}</td>
                                            <td>{{ $j->akhir_jam_masuk }}</td>
                                            <td>{{ $j->jam_pulang }}</td>
                                            <td>{{ $j->lokasi_kerja }}</td>
                                            <td>{{ $j->radius_kerja }}</td>

                                            <td>
                                                <div class="btn-group">
                                                    <a href="#" class="editdata btn btn-success btn-sm" kode_jamkerja="{{ $j->kode_jamkerja }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                            <path d="M16 5l3 3" />
                                                        </svg>
                                                    </a>
                                                    <form action="/setting/jam_kerja/{{ $j->kode_jamkerja}}/deletejamkerja" method="POST" style="margin-left:5px">
                                                        @csrf
                                                        <a class="btn btn-danger btn-sm delete-confirm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M4 7h16" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                <path d="M10 12l4 4m0 -4l-4 4" />
                                                            </svg>
                                                        </a>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-tambahjamker" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Jam Kerja</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/setting/storejamkerja" method="POST" id="frmjamker">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M15 8l2 0" />
                                <path d="M15 12l2 0" />
                                <path d="M7 16l10 0" />
                            </svg>
                        </span>
                            <input type="text" value="" id="kode_jamkerja" name="kode_jamkerja" class="form-control" placeholder="Kode Jam Kerja">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M15 8l2 0" />
                                <path d="M15 12l2 0" />
                                <path d="M7 16l10 0" />
                            </svg>
                        </span>
                        <input type="text" value="" id="nama_jamkerja" name="nama_jamkerja" class="form-control" placeholder="Nama Jam Kerja">
                        {{-- <select name="nama_jamkerja" id="nama_jamkerja" class="form-control">
                            <option value="" selected>Nama Jam Kerja</option>
                            @foreach ($modekerja as $item)
                                <option value="{{ $item->kode_anper }}">{{ $item->nama_anper }}</option>
                            @endforeach
                        </select> --}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-play" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 7v5l2 2" />
                                <path d="M17 22l5 -3l-5 -3z" />
                                <path d="M13.017 20.943a9 9 0 1 1 7.831 -7.292" />
                            </svg>
                        </span>
                            <input type="text" value="" id="awal_jam_masuk" name="awal_jam_masuk" class="form-control" placeholder="Awal Jam Masuk">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-play" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 7v5l2 2" />
                                <path d="M17 22l5 -3l-5 -3z" />
                                <path d="M13.017 20.943a9 9 0 1 1 7.831 -7.292" />
                            </svg>
                        </span>
                            <input type="text" value="" id="jam_masuk" name="jam_masuk" class="form-control" placeholder="Jam Masuk">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-play" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 7v5l2 2" />
                                <path d="M17 22l5 -3l-5 -3z" />
                                <path d="M13.017 20.943a9 9 0 1 1 7.831 -7.292" />
                            </svg>
                        </span>
                            <input type="text" value="" id="akhir_jam_masuk" name="akhir_jam_masuk" class="form-control" placeholder="Akhir Jam Masuk">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-play" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 7v5l2 2" />
                                <path d="M17 22l5 -3l-5 -3z" />
                                <path d="M13.017 20.943a9 9 0 1 1 7.831 -7.292" />
                            </svg>
                        </span>
                            <input type="text" value="" id="jam_pulang" name="jam_pulang" class="form-control" placeholder="Jam Pulang">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-play" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 7v5l2 2" />
                                <path d="M17 22l5 -3l-5 -3z" />
                                <path d="M13.017 20.943a9 9 0 1 1 7.831 -7.292" />
                            </svg>
                        </span>
                            <input type="text" value="" id="lokasi_kerja" name="lokasi_kerja" class="form-control" placeholder="Lokasi Kerja">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-play" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 7v5l2 2" />
                                <path d="M17 22l5 -3l-5 -3z" />
                                <path d="M13.017 20.943a9 9 0 1 1 7.831 -7.292" />
                            </svg>
                        </span>
                            <input type="text" value="" id="radius_kerja" name="radius_kerja" class="form-control" placeholder="Radius">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-primary w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M14 4l0 4l-6 0l0 -4" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal-editjamker" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data Jam Kerja</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loadeditform">

        </div>
      </div>
    </div>
  </div>
@endsection
@push('myscript')
<script>
    $(function(){

        $("#awal_jam_masuk, #jam_masuk, #akhir_jam_masuk, #jam_pulang").mask("00:00");
        $("#btntambahjamker").click(function() { // function tombol edit data
            $("#modal-tambahjamker").modal("show");
        });
        $("#frmjamker").submit(function() {
            var kode_jamkerja = $("#kode_jamkerja").val();
            var nama_jamkerja = $("#nama_jamkerja").val();
            var awal_jam_masuk = $("#awal_jam_masuk").val();
            var akhir_jam_masuk = $("#akhir_jam_masuk").val();
            var jam_masuk = $("#jam_masuk").val();
            var jam_pulang = $("#jam_pulang").val();

            if(kode_jamkerja == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Kode Jam Kerja Harus Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                    }).then((result) => {$("#jamkerja").focus();
                });
                return false;
            } else if(nama_jamkerja == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Nama Jam Kerja Harus Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                    }).then((result) => {$("#nama_jamkerja").focus();
                });
                return false;
            } else if(awal_jam_masuk == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Awal Jam Masuk Harus Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                    }).then((result) => {$("#awal_jam_masuk").focus();
                });
                return false;
            } else if(jam_masuk == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Jam Masuk Harus Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                    }).then((result) => {$("#jam_masuk").focus();
                });
                return false;
            } else if(akhir_jam_masuk == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Akhir Jam Masuk Harus Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                    }).then((result) => {$("#akhir_jam_masuk").focus();
                });
                return false;
            } else if(jam_pulang == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Jam Pulang Harus Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                    }).then((result) => {$("#jam_pulang").focus();
                });
                return false;
            }
        });

        $(".editdata").click(function() {
            var kode_jamkerja = $(this).attr('kode_jamkerja');
            $.ajax( {
                type: 'POST',
                url: '/setting/editjamkerja',
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_jamkerja: kode_jamkerja
                },
                success: function(respond) {
                    $("#loadeditform").html(respond);
                }
            });
            $("#modal-editjamker").modal("show");
        });

        $(".delete-confirm").click(function(e) {
            var form = $(this).closest('form');
            e.preventDefault();
            Swal.fire({
                title: "Apakah yakin delete?",
                showCancelButton: true,
                confirmButtonText: "Delete",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire("Deleted!", "", "success");
                    }
                })
        });
    });
</script>
@endpush
