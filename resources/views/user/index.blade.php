@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <h2 class="page-title">
            Data Users
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
                                <a href="#" class="btn btn-primary" id="btnTambahUsers">
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
                                <form class="{{ URL::current() }}" method="GET">
                                    <div class="row">
                                        <div class="col-10"> {{-- input cari divisi --}}
                                            <div class="form-group">
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Nama Users" value="{{ request('name') }}">
                                            </div>
                                        </div>
                                        <div class="col-2"> {{-- button cari divisi --}}
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                        <path d="M21 21l-6 -6" />
                                                    </svg>
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
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Divisi</th>
                                            <th>Role</th>
                                            <th width:>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $d )
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->name }}</td>
                                            <td>{{ $d->email }}</td>
                                            <td>{{ $d->nama_div }}</td>
                                            <td>{{ ucwords($d->role) }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <a href="#" class="edit btn btn-success btn-sm" id_user="{{ $d->id }}" >
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                <path d="M16 5l3 3" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <form action="/setting/users/{{ $d->id}}/deleteuser" method="POST" style="margin-left:5px">
                                                            @csrf
                                                            <a class="btn btn-danger btn-sm delete-confirm">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                    <path d="M4 7h16" />
                                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                    <path d="M10 12l4 4m0 -4l-4 4" />
                                                                </svg>
                                                            </a>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $users->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- modal tambah user --}}
<div class="modal modal-blur fade" id="modal-tambahusers" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Users</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/setting/users/store" method="POST" id="frmusers">
            @csrf
            <div class="row mt-1">
                <div class="col-12">
                    <div class="input-icon">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M15 8l2 0" />
                                <path d="M15 12l2 0" />
                                <path d="M7 16l10 0" />
                            </svg>
                        </span>
                            <input type="text" value="" id="nama_user" name="nama_user" class="form-control" placeholder="Nama User">
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-12">
                    <div class="input-icon">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                <path d="M3 7l9 6l9 -6" />
                            </svg>
                        </span>
                            <input type="text" value="" id="email" name="email" class="form-control" placeholder="Email">
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-12">
                    <div class="form-group">
                        <select name="kode_div" id="kode_div" class="form-select">
                            <option value="">Divisi</option>
                            @foreach ($divisi as $d )
                            <option value="{{ $d->kode_div }}">{{ $d->nama_div }}</option>

                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-12">
                    <div class="form-group">
                        <select name="role" id="role" class="form-select">
                            <option value="">Role</option>
                            @foreach ($role as $d )
                            <option value="{{ $d->name }}">{{ ucwords($d->name)}}</option>

                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-12">
                    <div class="input-icon">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-samsungpass" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 10m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                            <path d="M7 10v-1.862c0 -2.838 2.239 -5.138 5 -5.138s5 2.3 5 5.138v1.862" />
                            <path d="M10.485 17.577c.337 .29 .7 .423 1.515 .423h.413c.323 0 .633 -.133 .862 -.368a1.27 1.27 0 0 0 .356 -.886c0 -.332 -.128 -.65 -.356 -.886a1.203 1.203 0 0 0 -.862 -.368h-.826a1.2 1.2 0 0 1 -.861 -.367a1.27 1.27 0 0 1 -.356 -.886c0 -.332 .128 -.651 .356 -.886a1.2 1.2 0 0 1 .861 -.368h.413c.816 0 1.178 .133 1.515 .423" />
                        </svg>
                        </span>
                            <input type="password" value="" id="password" name="password" class="form-control" placeholder="Password">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
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
  <div class="modal modal-blur fade" id="modal-edituser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loadedituser">

        </div>
      </div>
    </div>
  </div>
@endsection
@push('myscript')
<script>
    $(function(){
        $("#btnTambahUsers").click(function() {
            $("#modal-tambahusers").modal("show");
        });

        $("#frmusers").submit(function(){
            var nama_user = $("#nama_user").val();
            var email = $("#email").val();
            var password = $("#password").val();
            var kode_div = $("#kode_div").val();
            var role = $("#role").val();

            if(nama_user == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Nama Harus Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#nama_user").focus();
                });
                return false;
            } else if(email == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Email Harus Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#email").focus();
                });
                return false;
            } else if(kode_div == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Divisi Harus Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#kode_div").focus();
                });
                return false;
            } else if(role == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Role Harus Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#role").focus();
                });
                return false;
            } else if(password == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Password Harus Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#password").focus();
                });
                return false;
            }
        });

        $(".edit").click(function() {
            var id_user = $(this).attr('id_user');
            $.ajax( {
                type: 'POST',
                url: '/setting/users/edit',
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    id_user: id_user
                },
                success: function(respond) {
                    $("#loadedituser").html(respond);
                }
            });
            $("#modal-edituser").modal("show");
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
