@extends('admin.layouts.app')
@section('title', $modulename)
@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>{{ $modulename }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $modulename }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section mb-5">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title"><i class="fa-solid fa-user-gear"></i> Manage {{ $modulename }}
                                    </h5>
                                </div>

                            </div>
                        </div>
                        <form method="post" id="pass" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="row ">
                                            <div class="col-md-12 mb-2">
                                                <label for="current_password">Current Password <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input id="current_password" name="current_password" type="password"
                                                        class="form-control" autocomplete="current-password"
                                                        placeholder="Enter Current Password" oncopy="return disableCopy();"
                                                        onpaste="return disablePaste();" oncut="return disableCut();"
                                                        oncontextmenu="return disableContextMenu();">
                                                    <span class="input-group-append">
                                                        <button tabindex="-1" type="button" id="Current_Password_Btn"
                                                            class="btn btn-light btn-flat"><i id="cur_btn"
                                                                class="fa-solid fa-lock"></i></button>
                                                    </span>
                                                    <div class="col-12"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <label for="password">New Password <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input id="password" name="password" type="password"
                                                        class="form-control" autocomplete="new-password"
                                                        placeholder="Enter New Password" oncopy="return disableCopy();"
                                                        onpaste="return disablePaste();" oncut="return disableCut();"
                                                        oncontextmenu="return disableContextMenu();">
                                                    <span class="input-group-append">
                                                        <button tabindex="-1" type="button" id="password_btn"
                                                            class="btn btn-light btn-flat"><i id="pass_btn"
                                                                class="fa-solid fa-lock"></i></button>
                                                    </span>
                                                    <div class="col-12"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-2">
                                                <label for="password_confirmation">Confirm Password <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input id="password_confirmation" name="password_confirmation"
                                                        type="password" class="form-control" autocomplete="new-password"
                                                        placeholder="Enter Confirm Password" oncopy="return disableCopy();"
                                                        onpaste="return disablePaste();" oncut="return disableCut();"
                                                        oncontextmenu="return disableContextMenu();">
                                                    <span class="input-group-append">
                                                        <button tabindex="-1" type="button" id="password_confirmation_btn"
                                                            class="btn btn-light btn-flat"><i id="pass_con_btn"
                                                                class="fa-solid fa-lock"></i></button>
                                                    </span>
                                                    <div class="col-12"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <hr>
                                                <button class="btn btn-success mr-2" type="submit"><i
                                                        class="fa-solid fa-file-pen"></i>
                                                    Update
                                                </button>
                                                <a class="btn btn-danger" href="{{ route('dashboard') }}"><i
                                                        class="fa-solid fa-xmark"></i> Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </section>

    </main><!-- End #main -->

@endsection
@section('script')
    <script>
        @if (session('status'))
            Swal.fire({
                title: "Success",
                text: "{{ Session::get('status') }}",
                icon: 'success',
                showCloseButton: true,
                confirmButtonText: '<i class="fa-regular fa-thumbs-up"></i> Great!',
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: "Error",
                text: "{{ Session::get('error') }}",
                icon: 'error',
                showCloseButton: true,
                confirmButtonText: 'Ok !',
            });
        @endif

        $(document).ready(function() {
            $('#pass').validate({
                rules: {
                    current_password: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    current_password: {
                        required: "Current password is required.",
                    },
                    password: {
                        required: "New password is required.",
                    },
                    password_confirmation: {
                        required: "Confirm password is required.",
                        equalTo: "Confirm password is not same as password."
                    }
                },
                errorPlacement: function(error, element) {
                    error.css('color', 'red').appendTo(element.parent("div"));
                },
                submitHandler: function(form) {
                    $(':button[type="submit"]').prop('disabled', true);
                    form.submit();
                }
            });

            //current_password_eye_btn for view enter password
            $("#Current_Password_Btn").click(function(e) {
                e.preventDefault();
                var input = $("#current_password");
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                    $('#cur_btn').removeClass('fa-solid fa-lock');
                    $('#cur_btn').addClass('fa-solid fa-unlock-keyhole');
                } else {
                    input.attr("type", "password");
                    $('#cur_btn').removeClass('fa-solid fa-unlock-keyhole');
                    $('#cur_btn').addClass('fa-solid fa-lock');
                }
            });

            //password_eye_btn for view enter password
            $("#password_btn").click(function(e) {
                e.preventDefault();
                var input = $("#password");
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                    $('#pass_btn').removeClass('fa-solid fa-lock');
                    $('#pass_btn').addClass('fa-solid fa-unlock-keyhole');
                } else {
                    input.attr("type", "password");
                    $('#pass_btn').removeClass('fa-solid fa-unlock-keyhole');
                    $('#pass_btn').addClass('fa-solid fa-lock');
                }
            });

            //password_confirmation_eye_btn for view enter password
            $("#password_confirmation_btn").click(function(e) {
                e.preventDefault();
                var input = $("#password_confirmation");
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                    $('#pass_con_btn').removeClass('fa-solid fa-lock');
                    $('#pass_con_btn').addClass('fa-solid fa-unlock-keyhole');
                } else {
                    input.attr("type", "password");
                    $('#pass_con_btn').removeClass('fa-solid fa-unlock-keyhole');
                    $('#pass_con_btn').addClass('fa-solid fa-lock');
                }
            });
        });
    </script>
    <script language="javascript" type="text/javascript">
        function disableCopy() {
            Swal.fire({
                title: "Error",
                text: "You cannot perform Copy.",
                icon: 'error',
                showCloseButton: true,
                confirmButtonText: 'Ok !',
            });
            return false;
        }

        function disablePaste() {
            Swal.fire({
                title: "Error",
                text: "You cannot perform Paste.",
                icon: 'error',
                showCloseButton: true,
                confirmButtonText: 'Ok !',
            });
            return false;
        }

        function disableCut() {
            Swal.fire({
                title: "Error",
                text: "You cannot perform Cut.",
                icon: 'error',
                showCloseButton: true,
                confirmButtonText: 'Ok !',
            });
            return false;
        }

        function disableContextMenu() {
            Swal.fire({
                title: "Error",
                text: "You cannot perform right click via mouse as well as keyboard.",
                icon: 'error',
                showCloseButton: true,
                confirmButtonText: 'Ok !',
            });

            return false;
        }
    </script>
@endsection
