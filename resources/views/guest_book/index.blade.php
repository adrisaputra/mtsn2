@extends('layouts.app2')

@section('title', 'Buku Tamu |')
@section('style')
        <!-- Toastr css -->
        <script type="text/javascript" src="{{ asset('guest_book/js/webcam.min.js') }}"></script>
        <!-- Sweet Alert css -->
        <link href="{{ asset('guest_book/plugins/sweet-alert/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box" style="background-color: #8bc34a;">
                <div class="row">
                    <div class="col-lg-2 col-sm-12 col-sx-12">   
                        <img src="{{ asset('assets/core-admin/core-dist/img/qrcode.png') }}" height="100px">
                    </div>
                    <div class="col-lg-8 col-sm-12 col-sx-12">   
                        <center><img src="{{ asset('assets/core-admin/core-dist/img/banner.png') }}" height="100px" width="40%"></center>
                    </div>
                    <div class="col-lg-2 col-sm-12 col-sx-12">   
                        <img src="{{ asset('assets/core-admin/core-dist/img/16529656791.png') }}" height="100px" style="float: right;">
                    </div>
                </div>      
                </div>
            <!-- end row -->
            </div>
        <!-- container -->
    </div>
    <!-- content -->

    <!-- #content -->
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="box-header with-border" style="margin-bottom:50px;">
                    <div class="box-tools pull-left">
                        <div>
                            <button type="button" class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg">Isi Buku Tamu</button>
                            <a href="{{ url('/') }}" class="btn btn-warning btn-flat" title="Refresh halaman">Refresh</a>
                        </div>
                    </div>
                    <div class="box-tools pull-right">
                        <div class="form-inline">
                            <form action="{{ url('/guest_book/search2') }}" method="GET">
                                <div class="input-group margin">
                                    <input type="text" class="form-control" name="search" placeholder="Masukkan kata kunci pencarian" style="height: 35px;">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-danger btn-flat">cari</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
				@if ($message = Session::get('status'))
					<div class="alert alert-info alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i>Berhasil !</h4>
						{{ $message }}
					</div>
				@endif

                <table class="table table-hover m-0 tickets-list table-actions-bar dt-responsive nowrap" cellspacing="0" width="100%" >
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Tamu</th>
                            <th>No. HP</th>
                            <th>Asal Instansi</th>
                            <th>Yang Ingin Ditemui</th>
                            <th>Keperluan</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        @php $no=1; @endphp
                        @foreach($guest_book as $v)
                        <tr>
                            <td><b>{{ ($guest_book ->currentpage()-1) * $guest_book ->perpage() + $loop->index + 1 }}</b></td>
                            <td>{{ $v->guest_name }}</td>
                            <td>{{ $v->phone_number }}</td>
                            <td>{{ $v->agency_name }}</td>
                            <td>{{ $v->destination_name }}</td>
                            <td>{{ $v->necessity }}</td>
                            <td>{{ $v->created_at->format('d-m-Y H:i:s') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table><br>
                {{ $guest_book->appends(Request::only('search'))->links() }}
            </div>
            
        </div>
        <!--  Modal content for the above example -->
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myLargeModalLabel">Buku Tamu</h4>
                    </div>
                    <div class="modal-body">
                       <div class="row">
                            <div class="col-lg-6">           
                                    <form action="{{ url('/save_guest_book') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                    {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="nama_ortu">Nama Tamu<span class="text-danger">*</span></label>
                                            <input type="text" parsley-trigger="change" required="" placeholder="Masukan Nama Tamu" class="form-control" name="guest_name">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_ortu">No. HP<span class="text-danger">*</span></label>
                                            <input type="text" parsley-trigger="change" required="" placeholder="No. HP" class="form-control" name="phone_number">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_siswa">Asal Instansi<span class="text-danger">*</span></label>
                                            <input type="text" parsley-trigger="change" required="" placeholder="Masukan Asal Instansi" class="form-control" name="agency_name">
                                        </div>
                                        <div class="form-group">
                                            <label for="no_hp">Yang Ingin Ditemui<span class="text-danger">*</span></label>
                                            <input type="text" parsley-trigger="change" required="" placeholder="Masukan Yang Ingin Ditemui" class="form-control" name="destination_name" >
                                        </div>
                                        <div class="form-group">
                                            <label for="no_hp">Keperluan<span class="text-danger">*</span></label>
                                            <input type="text" parsley-trigger="change" required="" placeholder="Masukan Keperluan" class="form-control" name="necessity" >
                                        </div>
                                        <input type="hidden" class="form-control" name="photo" id="foto_bukutamu" >
                                        <div class="form-group text-right m-b-0">
                                            <button class="btn btn-custom waves-effect waves-light" type="submit" onClick="take_snapshot_bukutamu()">
                                                Simpan
                                            </button>
                                        </div>
                                    </form>
                            </div>
                            <!-- end col -->
                             <div class="col-lg-6">
	                            <div id="my_camera"></div>
                            </div>
                            <!-- end col -->
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!-- end col -->
        <!-- end col -->
        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="mySmallModalLabel">Small modal</h4>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>
    <!-- end row -->
@endsection
@section('script')
    <script src="{{ asset('guest_book/plugins/jquery-toastr/jquery.toast.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('guest_book/plugins/sweet-alert/sweetalert2.min.js') }}"></script>
    <script language="JavaScript">
        $(document).ready(function () {
            $('#datatable').dataTable();
        });
        var APP_URL = {!! json_encode(url('/')) !!};
        
        var shutter = new Audio();
            shutter.autoplay = false;
            shutter.src = navigator.userAgent.match(/Firefox/) ? APP_URL+'/guest_book/js/shutter.ogg' : APP_URL+'/guest_book/js/shutter.mp3';
            Webcam.set({
            width: 320,
            height: 240,
            image_format: 'png',
            jpeg_quality: 90
        });

        Webcam.attach( '#my_camera' );
        function take_snapshot_bukutamu() {
            shutter.play();
            Webcam.snap( function(data_uri) {
                var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
                    $('#foto_bukutamu').val(raw_image_data);
            } );
        }

        
    </script>
@endsection
                