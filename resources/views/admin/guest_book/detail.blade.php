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
			<h3 class="box-title">Detail {{ __($title) }}</h3>
		</div>
		
		<form action="" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<div class="form-group ">
						<label class="col-sm-2 control-label">{{ __('Nama Tamu') }}</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" placeholder="Nama Grup" name="guest_name" value="{{ $guest_book->guest_name }}" disabled>
						</div>
					</div>
					
					<div class="form-group ">
						<label class="col-sm-2 control-label">{{ __('Asal/Instansi') }}</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" placeholder="Nama Grup" name="agency_name" value="{{ $guest_book->agency_name }}" disabled>
						</div>
					</div>
					
					<div class="form-group ">
						<label class="col-sm-2 control-label">{{ __('Yang ingin ditemui') }}</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" placeholder="Nama Grup" name="destination_name" value="{{ $guest_book->destination_name }}" disabled>
						</div>
					</div>
					
					<div class="form-group ">
						<label class="col-sm-2 control-label">{{ __('Keperluan') }}</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" placeholder="Nama Grup" name="necessity" value="{{ $guest_book->necessity }}" disabled>
						</div>
					</div>
					
					<div class="form-group ">
						<label class="col-sm-2 control-label">{{ __('Foto') }}</label>
						<div class="col-sm-10">
							@if($guest_book->photo)
								<a href="{{ url('upload/images/'.$guest_book->photo) }}" target="_blank"><img src="{{ asset('upload/images/'.$guest_book->photo) }}" width="150px" height="150px"></a>
							@else
								<img src="{{ asset('upload/user/15.jpg') }}" class="img-circle" alt="User Image" width="150px" height="150px">
							@endif
						
							<div style="padding-top:10px">
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/'.Request::segment(1)) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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