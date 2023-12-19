@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">
            Data Ijin / Sakit Karyawan
          </h2>
        </div>
      </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
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
                <form action="/presensi/perijinankaryawan" method="GET" autocomplete="off">
                    <div class="row">
                        <div class="col-6">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                    <path d="M16 3l0 4" />
                                    <path d="M8 3l0 4" />
                                    <path d="M4 11l16 0" />
                                    <path d="M8 15h2v2h-2z" />
                                </svg>
                                </span>
                                    <input type="text" value="{{ Request('dari') }}" id="dari" name="dari" class="form-control" placeholder="dari">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                    <path d="M16 3l0 4" />
                                    <path d="M8 3l0 4" />
                                    <path d="M4 11l16 0" />
                                    <path d="M8 15h2v2h-2z" />
                                </svg>
                                </span>
                                    <input type="text" value="{{ Request('sampai') }}" id="sampai" name="sampai" class="form-control" placeholder="sampai">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id-badge-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M7 12h3v4h-3z" />
                                    <path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" />
                                    <path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                    <path d="M14 16h2" />
                                    <path d="M14 12h4" />
                                </svg>
                                </span>
                                    <input type="text" value="{{ Request('nip') }}" id="nip" name="nip" class="form-control" placeholder="NIP">
                            </div>
                        </div>
                        <div class="col-3">
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
                                    <input type="text" value="{{ Request('nama_lengkap') }}" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Nama Karyawan">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <select name="statusapproval" id="statusapproval" class="form-select">
                                    <option value=""> Pilih status </option>
                                    <option value="0"{{  Request('statusapproval') === '0' ? 'selected' : '' }}>Pending</option>
                                    <option value="1"{{  Request('statusapproval') == 1 ? 'selected' : '' }}>Disetujui</option>
                                    <option value="2"{{  Request('statusapproval') == 2 ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-imac-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M11 17h-7a1 1 0 0 1 -1 -1v-12a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v8" />
                                        <path d="M3 13h10" />
                                        <path d="M8 21h4" />
                                        <path d="M10 17l-.5 4" />
                                        <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                        <path d="M20.2 20.2l1.8 1.8" />
                                    </svg>
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr style="font-weight: bold">
                            <th>No</th>
                            <th>Tanggal Ijin</th>
                            <th>Kode Ijin</th>
                            <th>NIP</th>
                            <th>Nama Karyawan</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Alasan</th>
                            <th>Status Approve</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($perijinankaryawan as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d-m-Y', strtotime($p->tgl_ijin_dari)) }} s/d {{ date('d-m-Y', strtotime($p->tgl_ijin_sampai)) }}</td>
                                <td>{{ $p->kode_ijin }}</td>
                                <td>{{ $p->nip }}</td>
                                <td>{{ $p->nama_lengkap }}</td>
                                <td>{{ $p->jabatan }}</td>
                                <td>{{ $p->status == "i" ? "Ijin" : "Sakit" }}</td>
                                <td>{{ $p->alasan }}</td>
                                <td>
                                    @if($p->status_approval==1)
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif ($p->status_approval==2)
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($p->status_approval==0)
                                    <a href="#" class="btn btn-sm btn-primary status_approval"  kode_ijin="{{ $p->kode_ijin }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-external-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" />
                                            <path d="M11 13l9 -9" />
                                            <path d="M15 4h5v5" />
                                        </svg>
                                        Action
                                    </a>
                                    @else
                                    <a href="/presensi/{{ $p->kode_ijin }}/batalkanapproval" class="btn btn-sm btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-xbox-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 21a9 9 0 0 0 9 -9a9 9 0 0 0 -9 -9a9 9 0 0 0 -9 9a9 9 0 0 0 9 9z" />
                                            <path d="M9 8l6 8" />
                                            <path d="M15 8l-6 8" />
                                        </svg>
                                        Batalkan
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $perijinankaryawan->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal-perijinankaryawan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Perijinan Karyawan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/presensi/approvalijinkaryawan" method="POST">
                @csrf
                <input type="hidden" id="kode_ijin_form" name="kode_ijin_form">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <select name="status_approval" id="status_approval" class="form-select">
                                <option value="1">Disetujui</option>
                                <option value="2">Ditolak</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 12l5 5l10 -10" />
                                </svg>
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('myscript')
<script>
    $(function () {
        $(".status_approval").click(function(e) {
            e.preventDefault();
            var kode_ijin = $(this).attr("kode_ijin");
            $("#kode_ijin_form").val(kode_ijin);
            $("#modal-perijinankaryawan").modal("show");
        });

        $("#dari, #sampai").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

    });
</script>
@endpush
