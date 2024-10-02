<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ae' ? 'rtl' : '' }}" data-layout="semibox" data-sidebar-visibility="show" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | Milafi - Admin & Dashboard Template</title>
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
    function clearClientFields (){
        $('#name').val("")
        $('#name').attr('class', "form-control")
        $('#contact_info').val("");
        $('#contact_info').attr('class', "form-control")
        const genderInputs = $('input[name="gender"]');
        genderInputs.each((index, elm) => {
            $(elm).prop('checked', false);
        });
        $("#address").val("");
        $('#address').attr('class', "form-control")
        $("#CIN").val("");
        $('#CIN').attr('class', "form-control")
    }
    const token = $('meta[name="csrf-token"]').attr('content');
    const FormSubmitionJudge = (event, method, url)=>{
        event.preventDefault();
        const form = event.target;
        const name = form.elements['name'].value;
        const gender = form.elements['gender'].value;
        const contact_info = form.elements['contact_info'].value;
        const court = form.elements['court'].value;

        $.ajax({
            url: url, 
            method: method,
            data: {name, gender, contact_info, court},
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
                $('.btn-close').click();
                toastr[res['alert-type']](res.message)
                let elements = judgeSelect.config.choices
                elements.push({value: res.data.id , label: res.data.name, selected: true, disabled: false, placeholder: false})
                judgeSelect.clearStore(); 
                judgeSelect.setChoices(elements, 'value', 'label', false);
                form.elements['name'].value = "";
                form.elements['contact_info'].value = ""
                form.elements['court'].selectedIndex = 0; // This selects the first option
                const genderRadios = form.elements['gender'];
                for (let i = 0; i < genderRadios.length; i++) {
                    genderRadios[i].checked = false;
                }

            },
            error: (xhr, status, error)=>{
                const err = xhr.responseJSON.errors
                for(const key in err){
                    const input = form.elements[key] 
                    input.classList.add('is-invalid');
                    $(input).next('.invalid-feedback').html(`<strong>${err[key]}</strong>`);
                }
            }
        })
    }
    const FormSubmition = (event, method, url)=>{
        event.preventDefault();
        const form = event.target;
        const name = form.elements['name'].value;
        const gender = form.elements['gender'].value;
        const contact_info = form.elements['contact_info'].value;
        const CIN = form.elements['CIN'].value;
        const address = form.elements['address'].value;
        $.ajax({
            url: url, 
            method: method,
            data: {name, gender, contact_info, CIN, address},
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
                $('.btn-close').click();
                toastr[res['alert-type']](res.message)

                let elements = clientSelect.config.choices
                elements.push({value: res.data.id , label: res.data.name, selected: true, disabled: false, placeholder: false})
                clientSelect.clearStore(); 
                clientSelect.setChoices(elements, 'value', 'label', false);
                fillPhoneInput(null, res.data.contact_info);
                clearClientFields()
            },
            error: (xhr, status, error)=>{
                const err = xhr.responseJSON.errors
                for(const key in err){
                    const input = form.elements[key] 
                    input.classList.add('is-invalid');
                    $(input).next('.invalid-feedback').html(`<strong>${err[key]}</strong>`);
                }

            }
        });
       
    }

</script>
</html>
