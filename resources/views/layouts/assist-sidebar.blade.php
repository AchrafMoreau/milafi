
<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="/dashboard" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/Logo-02.png') }}" alt="" height="44">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/Logo-02.png') }}" alt=""  style="height:auto; width:80%; object-fit:cover; margin:auto;">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/Logo-01.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/Logo-01.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span>@lang('translation.laywers')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            @
                            <li class="nav-item">
                                <a href="/todo" class="nav-link">@lang('translation.todo')</a>
                            </li>
                            <li class="nav-item">
                                <a href="/contact" class="nav-link">@lang('translation.yourContact')</a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->


                <li class="nav-item">
                    <a class="nav-link menu-link" href="/client" >
                        <i class="ri-account-circle-line"></i> 
                        <span>@lang('translation.clients')</span> 
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="/calendar" >
                        <i class=" las la-calendar"></i> 
                        <span>@lang('translation.calendar')</span> 
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/cas" >
                        <i class="ri-pages-line"></i> 
                        <span>@lang('translation.cases')</span> 
                    </a>
                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/judge" >
                        <i class="ri-honour-line"></i> 
                        <span>@lang('translation.judges')</span> 
                    </a>
                </li> <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="/court" >
                        <i class="ri-layout-3-line"></i> 
                        <span>@lang('translation.courts')</span> 
                    </a>
                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/document" >
                        <i class="ri-file-list-3-line"></i>
                        <span>@lang('translation.documents')</span> 
                    </a>
                </li> <!-- end Dashboard Menu -->


           

                

                

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
