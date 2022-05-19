
            <div class="left side-menu">

            @php
$setting = SiteHelpers::setting();
@endphp
                <div class="slimscroll-menu" id="remove-scroll">

                    <!-- LOGO -->
                    <div class="topbar-left">
                        <a href="index.html" class="logo">
                            <span>
                                <img src="{{ asset('upload/setting/' . $setting->large_icon) }}" alt="" height="50">
                            </span>
                            <i>
                                <img src="{{ asset('upload/setting/' . $setting->small_icon) }}" alt="" height="50">
                            </i>
                        </a>
                    </div>


                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->