@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">
            Setting Jam Kerja Divisi
          </h2>
        </div>
      </div>
    </div>
</div>
{{-- Halaman SETTING JAM KERJA --}}
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-8">
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
                                <a href="/setting/jamkerjadiv/create" class="btn btn-primary" id="btntambahjamker">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    Tambah Data
                                </a>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr style="text-align: center">
                                            <th style="text-align: center">No</th>
                                            <th>Kode</th>
                                            <th>Anper</th>
                                            <th>Divisi</th>
                                            <th width:>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jamkerjadiv as $j )
                                        <tr>
                                            <td> {{ $loop->iteration }}</td>
                                            <td> {{ $j->kode_jk_div }}</td>
                                            <td> {{ $j->nama_anper }}</td>
                                            <td> {{ $j->nama_div }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="/setting/jamkerjadiv/{{ $j->kode_jk_div }}/edit" class="edit btn btn-success btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                            <path d="M16 5l3 3" />
                                                        </svg>
                                                    </a>
                                                    <a href="/setting/jamkerjadiv/{{ $j->kode_jk_div }}/show" class="edit btn btn-info btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-cog" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                            <path d="M12 18c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                            <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                            <path d="M19.001 15.5v1.5" />
                                                            <path d="M19.001 21v1.5" />
                                                            <path d="M22.032 17.25l-1.299 .75" />
                                                            <path d="M17.27 20l-1.3 .75" />
                                                            <path d="M15.97 17.25l1.3 .75" />
                                                            <path d="M20.733 20l1.3 .75" />
                                                        </svg>
                                                    </a>
                                                    <a href="/setting/jamkerjadiv/{{ $j->kode_jk_div }}/delete" class="edit btn btn-danger btn-sm delete-confirm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M4 7l16 0" />
                                                            <path d="M10 11l0 6" />
                                                            <path d="M14 11l0 6" />
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                        </svg>
                                                    </a>
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
@endsection

@push('myscript')
<script>
    $(function() {
        $(".delete-confirm").click(function(e) {
            var url = $(this).attr('href');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah yakin delete?',
                text: 'Jika Ya, maka data akan terhapus permanent!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                }).then((result) => {
                    if (result.isConfirmed) {
                    window.location.href = url;
                    Swal.fire('Deleted!', 'success')
                    }
                })
        });
    });
</script>
@endpush


