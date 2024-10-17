@extends('layout.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <h2 class="page-title">
            Data Perangkat Desa
          </h2>
        </div>
  
      </div>
    </div>
  </div>
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
                                <a href="#" class="btn btn-primary" id="btnTambahperangkatdesa">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                    Tambah Data
                                </a>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <form action="/perangkatdesa" method="GET">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" name="nama_perangkatdesa" id="nama_perangkatdesa" class="form-control" placeholder="Nama Perangkat Desa" value="{{ Request('nama_perangkatdesa') }}">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <select name="kode_desa" id="kode_desa" class="form-select">
                                                    <option value="">Desa</option>
                                                    @foreach ($desa as $d)
                                                        <option {{ Request('kode_desa')==$d->kode_desa ? 'selected' : ''}} value="{{ $d->kode_desa }}">{{ $d->nama_desa }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                                    Cari
                                                </button>
                                            </div>
                                        </div>
                                    </div>  
                                </form>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>ID</th>
                                            <th>Nama Lengkap</th>
                                            <th>Jabatan</th>
                                            <th>No HP</th>
                                            <th>Foto</th>
                                            <th>Desa</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($perangkatdesa as $d)
                                        @php
                                            $path = Storage::url('uploads/perangkatdesa/'.$d->foto);
                                        @endphp
                                            <tr>
                                                <td>{{ $loop->iteration + $perangkatdesa->firstitem()-1 }}</td>
                                                <td>{{ $d->PD_ID }}</td>
                                                <td>{{ $d->nama_lengkap }}</td>
                                                <td>{{ $d->jabatan }}</td>
                                                <td>{{ $d->no_hp }}</td>
                                                <td>
                                                    @if (empty($d->foto))
                                                    <img src="{{ asset('assets/img/no_foto.webp') }}" class="avatar" alt="">
                                                    @else
                                                    <img src="{{ url($path) }}" class="avatar" alt="">
                                                    @endif
                                                    
                                                </td>
                                                <td>{{ $d->nama_desa }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="#" class="edit btn btn-info btn-sm mr-2" PD_ID="{{ $d->PD_ID }}">
                                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                                        </a>

                                                        <form action="/perangkatdesa/{{ $d->PD_ID }}/delete" method="POST" style="margin-left: 5px">
                                                            @csrf
                                                            <a class="btn btn-danger btn-sm delete-confirm">
                                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                            </a>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $perangkatdesa->links('vendor.pagination.bootstrap-5') }}
                            </div>
                            </div>
                        </div>  
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal-inputperangkatdesa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Perangkat Desa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/perangkatdesa/store" method="POST" id="frmperangkatdesa" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                              <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-barcode"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7v-1a2 2 0 0 1 2 -2h2" /><path d="M4 17v1a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v1" /><path d="M16 20h2a2 2 0 0 0 2 -2v-1" /><path d="M5 11h1v2h-1z" /><path d="M10 11l0 2" /><path d="M14 11h1v2h-1z" /><path d="M19 11l0 2" /></svg>
                            </span>
                            <input type="text" value="" class="form-control" id="PD_ID" name="PD_ID" placeholder="Perangkat Desa ID">
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                              <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2a5 5 0 1 1 -5 5l.005 -.217a5 5 0 0 1 4.995 -4.783z" /><path d="M14 14a5 5 0 0 1 5 5v1a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-1a5 5 0 0 1 5 -5h4z" /></svg>
                            </span>
                            <input type="text" value="" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap">
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                              <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-badge"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.486 3.143l-4.486 2.69l-4.486 -2.69a1 1 0 0 0 -1.514 .857v13a1 1 0 0 0 .486 .857l5 3a1 1 0 0 0 1.028 0l5 -3a1 1 0 0 0 .486 -.857v-13a1 1 0 0 0 -1.514 -.857z" /></svg>
                            </span>
                            <input type="text" value="" class="form-control" id="jabatan" name="jabatan" placeholder="Jabatan">
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                              <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" /><path d="M11 4h2" /><path d="M12 17v.01" /></svg>
                            </span>
                            <input type="text" value="" class="form-control" id="no_hp" name="no_hp" placeholder="No Hanphone">
                          </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                            <input type="file" name="foto" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <select name="kode_desa" id="kode_desa" class="form-select">
                            <option value="">Desa</option>
                            @foreach ($desa as $d)
                                <option {{ Request('kode_desa')==$d->kode_desa ? 'selected' : ''}} value="{{ $d->kode_desa }}">{{ $d->nama_desa }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-primary w-100">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-send"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14l11 -11" /><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" /></svg>
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
{{-- modal-edit --}}
<div class="modal modal-blur fade" id="modal-editperangkatdesa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data Perangkat Desa</h5>
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
            $("#btnTambahperangkatdesa").click(function() {               
                $("#modal-inputperangkatdesa").modal("show");
            });

            $(".edit").click(function() {               
                var PD_ID = $(this).attr('PD_ID');
                $.ajax({
                    type:'POST',
                    url:'/perangkatdesa/edit',
                    cache:false,
                    data:{
                        _token:"{{ csrf_token(); }}",
                        PD_ID:PD_ID,
                    },
                    success:function(respond){
                        $("#loadeditform").html(respond);
                    }
                });
                $("#modal-editperangkatdesa").modal("show");
            });

            $(".delete-confirm").click(function(e){
                var form = $(this).closest('form');
                e.preventDefault();
                Swal.fire({
                    title: "Apakah Anda Yakin Data ini Akan Di Hapus ?",
                    text: "Jika iya data akan terhapus Permanen",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya. Hapus Saja !"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    Swal.fire({
                    title: "Deleted!",
                    text: "Data Berhasil Di Hapus.",
                    icon: "success"
                });
                }
                })

            });

            $("#frmperangkatdesa").submit(function(){
                var PD_ID = $("#PD_ID").val();
                var nama_lengkap = $('#nama_lengkap').val();
                var jabatan = $("#jabatan").val();
                var no_hp = $("#no_hp").val();
                var kode_desa = $("frmperangkatdesa").find("#kode_desa").val();
                if (PD_ID=="") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'ID Harus Di isi!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#PD_ID").focus();
                    });
                    return false;
                }else if(nama_lengkap==""){
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Nama Harus Di isi !',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#nama_lengkap").focus();
                    });
                    return false;
                }else if(jabatan==""){
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Jabatan Harus Di isi !',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#jabatan").focus();
                    });
                    return false;
                }else if(no_hp==""){
                    Swal.fire({
                        title: 'Warning!',
                        text: 'No Hanphone Harus Di isi !',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#no_hp").focus();
                    });
                    return false;
                }else if(kode_desa==""){
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Desa Harus Di Pilih !',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#kode_desa").focus();
                    });
                    return false;
                }
            });
        });
    </script>
@endpush