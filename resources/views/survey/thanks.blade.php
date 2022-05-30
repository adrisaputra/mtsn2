@extends('layouts.app2')

@section('title', 'Buku Tamu |')
@section('style')
        <!-- Toastr css -->
        <script type="text/javascript" src="{{ asset('survey/js/webcam.min.js') }}"></script>
        <!-- Sweet Alert css -->
        <link href="{{ asset('survey/plugins/sweet-alert/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box" style="background-color: #8bc34a;">
                <center><img src="{{ asset('assets/core-admin/core-dist/img/banner.png') }}" height="120px"></center>
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
                <div class="form-group row mb-4">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <center><b><p style="font-size:24px">Terima Kasih Atas Penilaian Anda !!!</p></center></b>                                                                
                    </div>
                </div>
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
                                    <form action="{{ url('/survey') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
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
    <script src="{{ asset('survey/plugins/jquery-toastr/jquery.toast.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('survey/plugins/sweet-alert/sweetalert2.min.js') }}"></script>
    <script language="JavaScript">
        $(document).ready(function () {
            $('#datatable').dataTable();
        });
        var APP_URL = {!! json_encode(url('/')) !!};
        
        var shutter = new Audio();
            shutter.autoplay = false;
            shutter.src = navigator.userAgent.match(/Firefox/) ? APP_URL+'/survey/js/shutter.ogg' : APP_URL+'/survey/js/shutter.mp3';
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
                