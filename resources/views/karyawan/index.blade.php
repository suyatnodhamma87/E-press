@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <h2 class="page-title">
            Data Karyawan
          </h2>
        </div>
      </div>
    </div>
  </div>

{{-- Halaman Data Karyawan --}}
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
                        {{-- Button tambah data --}}
                        <div class="row">
                            <div class="col-12">
                                <a href="#" class="btn btn-primary" id="btnTambahkaryawan">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    Tambah data
                                </a>
                            </div>
                        </div>
                        {{-- Button tambah data --}}

                        <div class="row mt-2">
                            <div class="col-6">
                                <form class="/karyawan" method="GET">
                                    <div class="row">
                                        <div class="col-6"> {{-- input cari karyawan --}}
                                            <div class="form-group">
                                                <input type="text" name="nama_karyawan" id="nama_karyawan" class="form-control" placeholder="Nama karyawan" value="{{ request('nama_karyawan') }}">
                                            </div>
                                        </div>
                                        <div class="col-4"> {{-- select divisi karyawan --}}
                                            <div class="form-group">
                                                <select name="kode_div" id="kode_div" class="form-select">
                                                    <option value=""> Divisi</option>
                                                    @foreach ($divisi as $d)
                                                    <option {{ request('kode_div')==$d->kode_div ? 'selected' : ''}} value ="{{ $d->kode_div }}"> {{  $d->nama_div }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2"> {{-- button cari karyawan --}}
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                                    Cari
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-2"> {{-- Tabel data karyawan --}}
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr style="text-align: center">
                                            <th style="text-align: center">No</th>
                                            <th>NIP</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>No HP</th>
                                            <th>Foto</th>
                                            <th>Divisi</th>
                                            <th>Anak Perusahaan</th>
                                            <th width:>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($karyawan as $k)
                                            @php
                                                $path = Storage::url('uploads/karyawan/'.$k->foto);
                                            @endphp
                                            <tr>
                                                <td style="text-align: center">{{ $loop->iteration + $karyawan->firstItem() -1  }}</td>
                                                <td>{{ $k->nip}}</td>
                                                <td>{{ $k->nama_lengkap }}</td>
                                                <td>{{ $k->jabatan }}</td>
                                                <td>{{ $k->no_hp }}</td>
                                                <td style="text-align: center">
                                                    @if (empty($k->foto))
                                                        <img src="{{ asset('assets/img/nonprofile.png') }}" class="avatar" alt="">
                                                    @else
                                                        <img src="{{ url($path) }}" class="avatar" alt="">
                                                    @endif
                                                </td>
                                                <td style="text-align:center">
                                                    {{ $k->kode_div }}
                                                </td>
                                                <td style="text_align:center">
                                                    {{ $k->kode_anper }}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="#" class="edit btn btn-success btn-sn" nip="{{ $k->nip }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                <path d="M16 5l3 3" />
                                                            </svg>
                                                        </a>
                                                        <form action="/karyawan/{{ $k->nip}}/delete" method="POST" style="margin-left:5px">
                                                            @csrf
                                                            <a class="btn btn-danger btn-sn delete-confirm">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
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
                                {{ $karyawan->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal tambah karyawan --}}
<div class="modal modal-blur fade" id="modal-tambahkaryawan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Karyawan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/karyawan/store" method="POST" id="frmkaryawan" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                            <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M15 8l2 0" />
                                <path d="M15 12l2 0" />
                                <path d="M7 16l10 0" /></svg>
                            </span>
                                <input type="text" value="" id="nip" name="nip" class="form-control" placeholder="NIP">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                            <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                <path d="M16 19h6" />
                                <path d="M19 16v6" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4" /></svg>
                            </span>
                                <input type="text" value="" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                            <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-scan" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 9a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                                <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                                <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                                <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                                <path d="M8 16a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2" /></svg>
                            </span>
                                <input type="text" value="" id="jabatan" name="jabatan" class="form-control" placeholder="jabatan">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                            <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                <path d="M15 6h6m-3 -3v6" /></svg>
                            </span>
                                <input type="text" value="" id="no_hp" name="no_hp" class="form-control" placeholder="no_hp">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <select name="kode_div" id="kode_div" class="form-select">
                                <option value=""> Divisi</option>
                                @foreach ($divisi as $d)
                                <option {{ request('kode_div')==$d->kode_div ? 'selected' : ''}} value ="{{ $d->kode_div }}"> {{  $d->nama_div }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <select name="kode_anper" id="kode_anper" class="form-select">
                                <option value="">Anak Perusahaan</option>
                                @foreach ($anakperusahaan as $a)
                                <option value ="{{ $a->kode_anper }}">  {{ strtoupper($a->nama_anper)}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="mb-3">
                            <div class="form-label">Upload foto</div>
                            <input type="file" name="foto" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-primary">
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

{{-- modal edit data karyawan --}}
  <div class="modal modal-blur fade" id="modal-editkaryawan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data Karyawan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loadeditform">

        </div>
      </div>
    </div>
  </div>
@endsection

@push ('myscript')
<script>
    $(function(){
        $("#btnTambahkaryawan").click(function() { // function tombol edit karyawan
            $("#modal-tambahkaryawan").modal("show");

        });

        // function tombol edit karyawan
        $(".edit").click(function() {
            var nip = $(this).attr('nip');
            $.ajax( {
                type: 'POST',
                url: '/karyawan/edit',
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    nip: nip
                },
                success: function(respond) {
                    $("#loadeditform").html(respond);
                }
            });
            $("#modal-editkaryawan").modal("show");
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


        $("#frmkaryawan").submit(function() {
            var nip = $("#nip").val();
            var nama_lengkap = $("#nama_lengkap").val();
            var jabatan = $("#jabatan").val();
            var no_hp = $("#no_hp").val();
            var kode_div = S("frmkaryawan").find("#kode_div").val();
            if(nip == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'NIP Harus Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                    }).then((result) => {$("#nip").focus();
                });
                return false;
            } else if (nama_lengkap == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Nama Harus Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                    }).then((result) => {$("#nama_lengkap").focus();
                });
                return false;
            } else if (jabatan == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'jabatan Harus Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                    }).then((result) => {$("#jabatan").focus();
                });
                return false;
            } else if (no_hp == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'No HP Harus Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                    }).then((result) => {$("#no_hp").focus();
                });
                return false;
            } else if (kode_div == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Divisi Harus Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                    }).then((result) => {$("#kode_div").focus();
                });
                return false;
            }
        });


    });
</script>
@endpush