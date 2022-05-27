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
			<h3 class="box-title">Edit {{ __($title) }}</h3>
		</div>
		
		<form action="{{ url('/'.Request::segment(1).'/edit/'.Crypt::encrypt($incoming_mail->id)) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

				<div class="form-group @if ($errors->has('mail_number')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Nomor Surat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('mail_number'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('mail_number') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nomor Surat" name="mail_number" value="{{ $incoming_mail->mail_number }}" >
						</div>
					</div>

					<div class="form-group @if ($errors->has('letter_date')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Surat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('letter_date'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('letter_date') }}</label>@endif
							<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control datepicker" placeholder="Tanggal Surat" name="letter_date" value="{{ $incoming_mail->letter_date }}">
							</div>
						</div>
                         </div>

					<div class="form-group @if ($errors->has('sender')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Instansi Pengirim ') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('sender'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('sender') }}</label>@endif
							<input type="text" class="form-control" placeholder="Instansi Pengirim " name="sender" value="{{ $incoming_mail->sender }}" >
						</div>
					</div>

					<div class="form-group @if ($errors->has('entry_date')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Masuk') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('entry_date'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('entry_date') }}</label>@endif
							<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control datepicker" placeholder="Tanggal Masuk" name="entry_date" value="{{ $incoming_mail->entry_date }}">
							</div>
						</div>
                         </div>
					
					<div class="form-group @if ($errors->has('about')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Perihal') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('about'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('about') }}</label>@endif
							<textarea class="form-control" placeholder="Perihal" name="about">{{ $incoming_mail->about }}</textarea>
						</div>
					</div>

					<div class="form-group @if ($errors->has('link')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Link') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('link'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('link') }}</label>@endif
							<input type="text" class="form-control" placeholder="Link" name="link" value="{{ $incoming_mail->link }}" >
						</div>
					</div>

					<div class="form-group @if ($errors->has('file')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('File') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('file'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('file') }}</label>@endif
							<input type="file" class="form-control" placeholder="File" name="file" value="{{ $incoming_mail->file }}" >
							@if($incoming_mail->file)
							<a href="{{ asset('upload/file_surat_masuk/'.$incoming_mail->file) }}" target="_blank">Lihat File</a>
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
							<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
							<a href="{{ url('/'.Request::segment(1)) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
						</div>
					</div>
					
				</div>
			</div>
		</form>
	</div>
	</section>
</div>

@endsection