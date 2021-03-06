@php
    $setting = SiteHelpers::setting();
@endphp
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>PTSP MTsN 1 Kendari</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        @include('layouts._partials._style')
    </head>


    <body>

        <!-- Begin page -->
        <div id="wrapper">
            
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page" style="margin-left: 0px;padding: 0px 25px 15px 25px;">
                <!-- Top Bar Start -->
                {{--<div class="topbar">
                 <nav class="navbar-custom">

                    <ul class="list-unstyled topbar-right-menu float-right mb-0">

                        <li class="hide-phone app-search">
					        <form action="{{ url('/guest_book/search') }}" method="GET">
                                <input type="text" name="search" placeholder="Search..." class="form-control">
                                <button type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </li>

                    </ul>

                </nav>

                </div>--}}
                <!-- Top Bar End -->



                <!-- Start Page content -->
                <div class="content">
                    <div class="container-fluid">
                      <!-- #content -->
                      @yield('content')
                    </div> <!-- container -->
                </div> <!-- content -->

                <footer class="footer text-right" style="left: 0px;">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box" style="background-color: #8bc34a;padding: 0px;border-radius: 3px;margin-bottom: 0px;">
                            <marquee style="padding-left:10px;padding-right:10px">
                                <p style="color:#ffffff;font-size:20px;margin-top:10px;margin-bottom:5px">{{ $setting->running_text }} </p>
                            </marquee>     
                        </div>
                    <!-- end row -->
                    </div>
                <!-- container -->
                 </div>
                </footer>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->
        @include('layouts._partials._script')
    </body>
</html>