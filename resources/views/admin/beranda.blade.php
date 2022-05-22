@extends('admin/layout')
@section('konten')

<div class="content-wrapper">
	<section class="content-header">
	<h1 class="fontPoppins">
		
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
	</ol>
	</ol>
	</section>
	
	<section class="content">
	
	<div class="box-body">
			<!-- Small boxes (Stat box) -->
			<div class="row">
				<div class="col-lg-4 col-xs-4">
				<!-- small box -->
					<div class="small-box bg-green">
						<div class="inner">
						<h3>{{ $guest_book }}</h3>

						<p>Total Tamu</p>
						</div>
						<div class="icon">
						<i class="fa fa-users"></i>
						</div>
						<a href="{{ url('guest_book') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-4 col-xs-4">
				<!-- small box -->
					<div class="small-box bg-yellow">
						<div class="inner">
						<h3>{{ $incoming_mail }}</h3>

						<p>Total Surat Masuk</p>
						</div>
						<div class="icon">
						<i class="fa fa-envelope"></i>
						</div>
						<a href="{{ url('incoming_mail') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-4 col-xs-4">
				<!-- small box -->
					<div class="small-box bg-red">
						<div class="inner">
						<h3>{{ $outgoing_mail }}</h3>

						<p>Total Surat Keluar</p>
						</div>
						<div class="icon">
						<i class="fa fa-envelope"></i>
						</div>
						<a href="{{ url('outgoing_mail') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
			</div>
			<!-- /.row -->
	</section>
</div>
@endsection