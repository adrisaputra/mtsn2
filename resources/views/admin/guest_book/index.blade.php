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
			<div class="box-tools pull-left">
				<div style="padding-top:10px">
					<a href="{{ url('/'.Request::segment(1)) }}" class="btn btn-warning btn-flat" title="Refresh halaman">Refresh</a>
				</div>
			</div>
			<div class="box-tools pull-right">
				<div class="form-inline">
					<form action="{{ url('/'.Request::segment(1).'/search') }}" method="GET">
						<div class="input-guest_book margin">
							<input type="text" class="form-control" name="search" placeholder="Masukkan kata kunci pencarian">
							<span class="input-guest_book-btn">
								<button type="submit" class="btn btn-danger btn-flat">cari</button>
							</span>
						</div>
					</form>
				</div>
			</div>
		</div>
			
		@can('read-data')
			<div class="table-responsive box-body">

				@if ($message = Session::get('status'))
					<div class="alert alert-info alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i>Berhasil !</h4>
						{{ $message }}
					</div>
				@endif

				<table class="table table-bordered">
					<tr style="background-color: gray;color:white">
					<tr>
						<th>No.</th>
						<th>Nama Tamu</th>
						<th>Asal Instansi</th>
						<th>Yang Ingin Ditemui</th>
						<th>Keperluan</th>
						<th>Waktu</th>
						<th>Foto</th>
						<th style="width: 10%">#aksi</th>
					</tr>
					@foreach($guest_book as $v)
					<tr>
						<td><b>{{ ($guest_book ->currentpage()-1) * $guest_book ->perpage() + $loop->index + 1 }}</b></td>
						<td>{{ $v->guest_name }}</td>
						<td>{{ $v->agency_name }}</td>
						<td>{{ $v->destination_name }}</td>
						<td>{{ $v->necessity }}</td>
						<td>{{ $v->created_at->format('d-m-Y H:i:s') }}</td>
						<td>
							@if($v->photo)
								<a href="{{ url('upload/images/'.$v->photo) }}" target="_blank"><img src="{{ asset('upload/images/'.$v->photo) }}" width="150px" height="150px"></a>
							@else
								<img src="{{ asset('upload/user/15.jpg') }}" class="img-circle" alt="User Image" width="150px" height="150px">
							@endif
						</td>
						<td>
							@can('ubah-data')
								<a href="{{ url('/'.Request::segment(1).'/detail/'.Crypt::encrypt($v->id)) }}" class="btn btn-xs btn-flat btn-warning">Detail</a>
							@endcan
							@can('hapus-data')
								<a href="{{ url('/'.Request::segment(1).'/hapus/'.Crypt::encrypt($v->id) ) }}" class="btn btn-xs btn-flat btn-danger"  onclick="return confirm('Anda Yakin ?');">Hapus</a>
							@endcan
						</td>
					</tr>
					@endforeach
				</table>

			</div>
		@endcan
		<div class="box-footer">
			<!-- PAGINATION -->
			<div class="float-right">{{ $guest_book->appends(Request::only('search'))->links() }}</div>
		</div>
	</div>
	</section>
</div>
@endsection