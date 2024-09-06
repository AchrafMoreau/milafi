<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ae' ? 'rtl' : '' }}" data-layout="semibox" data-sidebar-visibility="show" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/Logo-02.png')}}">
    @include('layouts.head-css')
</head>
@section('body')
    @include('layouts.body')
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    @include('layouts.customizer')

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')
</body>

<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
     
    const token = $('meta[name="csrf-token"]').attr('content');
    const FormSubmition = (event, method, url)=>{
        event.preventDefault();
        const form = event.target;
        const name = form.elements['name'].value;
        const gender = form.elements['gender'].value;
        const contact = form.elements['contact'].value;
        const CIN = form.elements['CIN'].value;
        const address = form.elements['address'].value;
        $.ajax({
            url: url, 
            method: method,
            data: {name, gender, contact, CIN, address},
            constactType: 'application/json',
            headers:{
                'X-CSRF-TOKEN': token
            },
            beforeSend: ()=>{
                $('button#submit').html(`
                    <div style='width:1rem; height:1rem;' class="spinner-border text-success" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                `);
            },
            complete: ()=>{
                $('button#submit').html("@lang('translation.submit')");

            },
            success: (res) =>{
                console.log(res.success)
                window.location.reload();
                toastr[res['alert-type']](res.message)
            },
            error: (xhr, status, error)=>{
                const err = xhr.responseJSON.errors
                for(const key in err){
                    console.log(err[key])
                    const input = form.elements[key] 
                    input.classList.add('is-invalid');
                    $(input).next('.invalid-feedback').html(`<strong>${err[key]}</strong>`);
                }

            }
        });
       
    }
</script>
</html>
