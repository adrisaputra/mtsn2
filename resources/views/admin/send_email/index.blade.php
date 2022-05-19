@extends('admin.layout')
@section('konten')
    <div class="content-wrapper">
        <section class="content-header">
            <h1 class="fontPoppins">{{ __($title) }}
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
                <li><a href="#"> {{ __($title) }}</a></li>
            </ol>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Tambah {{ __($title) }}</h3>
                </div>

                <form action="{{ url('/' . Request::segment(1)) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="col-lg-12">

					   	@if ($message = Session::get('status'))
							<div class="alert alert-info alert-dismissible">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<h4><i class="icon fa fa-check"></i>Berhasil !</h4>
								{{ $message }}
							</div>
						@endif

                            <div class="form-group @if ($errors->has('email_address')) has-error @endif">
                                <label class="col-sm-2 control-label">{{ __('Alamat Email') }} <span class="required" style="color: #dd4b39;">*</span></label>
                                <div class="col-sm-10">
                                    @if ($errors->has('email_address'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('email_address') }}</label>@endif
                                    <input type="text" class="form-control" placeholder="Alamat Email" name="email_address" value="{{ old('email_address') }}">
                                </div>
                            </div>

                            <div class="form-group @if ($errors->has('subject')) has-error @endif">
                                <label class="col-sm-2 control-label">{{ __('Subject') }} <span class="required" style="color: #dd4b39;">*</span></label>
                                <div class="col-sm-10">
                                    @if ($errors->has('subject'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('subject') }}</label>@endif
                                    <input type="text" class="form-control" placeholder="Subject" name="subject" value="{{ old('subject') }}">
                                </div>
                            </div>

                            <div class="form-group @if ($errors->has('message')) has-error @endif">
                                <label class="col-sm-2 control-label">{{ __('Pesan') }} <span class="required" style="color: #dd4b39;">*</span></label>
                                <div class="col-sm-10">
                                    @if ($errors->has('message'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('message') }}</label>@endif
                                    <textarea class="form-control" placeholder="Pesan" name="message">{{ old('message') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10">
                                    <div style="padding-top:10px">
                                        <button type="submit" class="btn btn-primary btn-flat btn-sm" title="Kirim Email"> Kirim</button>
                                        <button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
                                        <a href="{{ url('/' . Request::segment(1)) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

@endsection
