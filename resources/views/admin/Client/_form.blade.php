@extends('admin.layouts.app')
@section('title', $modulename)
@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            {{-- <h1>{{ $modulename }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $modulename }}</li>
                </ol>
            </nav> --}}
        </div><!-- End Page Title -->

        <section class="section mb-5">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Edit {{ $modulename }}</h5>
                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>
                        </div>
                        <form id="add" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body mt-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" value="{{ $data->user_id }}" id="user_id" name="user_id">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label for="client_id">Client id<spna class="text-danger">*</spna></label>
                                        <input type="text" name="client_id" id="client_id" class="form-control"
                                            value="{{ $data->client_id }}" placeholder="Enter Client id" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name">Name<spna class="text-danger">*</spna></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Enter Name" value="{{ $data->name }}">
                                    </div>
                                </div>
                                <div class="row mb-2">

                                    <div class="col-md-6">
                                        <label for="mobile_no">Mobile Number<spna class="text-danger">*</spna></label>
                                        <input type="text" maxlength="10" name="mobile_no" id="mobile_no"
                                            class="form-control" placeholder="Enter Mobile Number"
                                            value="{{ $data->mobile_no }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            placeholder="Enter Email Address" value="{{ $data->email }}">
                                    </div>
                                </div>
                                <div class="row  mb-2">

                                    <div class="col-md-6">
                                        <label for="expiry_date">Expiry Date</label>
                                        <input type="text" name="expiry_date" id="expiry_date" class="form-control"
                                            placeholder="Enter Name" value="{{ $data->expiry_date }}" autocomplete="off">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="number_of_users">Number of user creating<spna class="text-danger">*
                                            </spna>
                                        </label>
                                        <input type="text" name="number_of_users" id="number_of_users"
                                            class="form-control" placeholder="Enter Number Of User Creating"
                                            value="{{ $data->number_of_users }}">
                                    </div>
                                </div>
                                <div class="row  mb-2">
                                    <div class="col-md-6">
                                        <label for="password">Password</label>
                                        <div class="input-group">

                                            <input type="password" name="password" id="password" class="form-control"
                                                placeholder="Enter Password">

                                            <span class="input-group-append" id="inputGroupPrepend">
                                                <button tabindex="-1" type="button" id="password_btn"
                                                    class="btn btn-light">
                                                    <i id="pass_btn" class="fa-solid fa-lock"></i>
                                                </button>
                                            </span>

                                            <div class="col-md-12"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="con_password">Confirm Password<spna class="text-danger">*</spna>
                                        </label>
                                        <div class="input-group">

                                            <input type="password" name="con_password" id="con_password"
                                                class="form-control" placeholder="Enter Confirm Password">

                                            <span class="input-group-append" id="inputGroupPrepend">
                                                <button tabindex="-1" type="button" id="password_confirmation_btn"
                                                    class="btn btn-light">
                                                    <i id="pass_con_btn" class="fa-solid fa-lock"></i>
                                                </button>
                                            </span>

                                            <div class="col-md-12"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row  mb-2">
                                    <div class="col-md-6">
                                        <label for="address">Address</label>
                                        <textarea name="address" id="address" class="form-control" placeholder="Enter Address">{{ $data->address }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="logo">Logo ( jpeg|jpg|png|webp )<spna class="text-danger">*
                                            </spna>
                                        </label>
                                        <input type="file" name="logo" id="logo" class="form-control">
                                    </div>

                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div id="view" class="d-flex justify-content-center">
                                            <img src="{{ asset('public/storage/clientlogo/' . $data->logo) }}"
                                                alt="Logo File Preview" width="150">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Login Type<span class="text-danger">*</span></label>
                                        <div class="mt-2 form-group clearfix">
                                            <div class="icheck-success d-inline ml-5">
                                                <input type="radio" id="single" name="login_type" value="1"
                                                    @if ($data->login_type == 1) checked @endif>
                                                <label for="single">Single Device
                                                </label>
                                            </div>
                                            <div class="icheck-success d-inline ml-5">
                                                <input type="radio" name="login_type" id="multiple" value="0"
                                                    @if ($data->login_type == 0) checked @endif>
                                                <label for="multiple">Multiple Device
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row ">
                                    <div class="col-md-12 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-success me-3"><i
                                                class="fa-solid fa-floppy-disk"></i>
                                            Update</button>
                                        <a class="btn btn-primary " href="{{ url()->previous() }}"><i
                                                class="fa-solid fa-x"></i> Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
@section('script')
    <script>
        @if (session('success'))
            Swal.fire({
                title: "Success",
                text: "{{ Session::get('success') }}",
                icon: 'success',
                showCloseButton: true,
                confirmButtonText: '<i class="fa-regular fa-thumbs-up"></i> Great!',
            });
        @endif

        $(document).ready(function() {

            $("#expiry_date").datepicker({
                dateFormat: 'yy-mm-dd',
            });

            $.validator.addMethod('expiry_date',
                function(value, element) {

                    if (this.optional(element)) {
                        return true;
                    }

                    var ok = true;
                    try {
                        $.datepicker.parseDate('yy/mm/dd', value);
                    } catch (err) {
                        ok = false;
                    }
                    console.log(ok)
                    return ok;
                });


            //validation
            $("#add").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    mobile_no: {
                        required: true,
                        minlength: 10,
                        digits: true,
                        remote: {
                            type: 'post',
                            url: '{{ url('edit-check-mobile-exists') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                user_id: function() {
                                    return $('#user_id').val();
                                },
                                mobile_no: function() {
                                    return $('#mobile_no').val();
                                }
                            }
                        }
                    },
                    email: {
                        email: true,
                        remote: {
                            type: 'post',
                            url: '{{ url('edit-check-email-exists') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                user_id: function() {
                                    return $('#user_id').val();
                                },
                                mobile_no: function() {
                                    return $('#email').val();
                                }
                            }
                        }
                    },
                    number_of_users: {
                        required: true,
                        digits: true,
                    },
                    con_password: {
                        equalTo: "#password"
                    },
                    logo: {
                        extension: "jpeg|jpg|png|webp",
                    },
                    expiry_date: {
                        dateISO: true
                    }
                },
                messages: {
                    name: {
                        required: "Name is required.",
                    },
                    mobile_no: {
                        required: "Mobile number is required.",
                        digits: "Enter Only Numbers.",
                        remote: "Mobile number already exists !",
                    },
                    email: {

                        email: "Please enter a valid email address.",
                        remote: "Email address already exists !",
                    },
                    number_of_users: {
                        required: "Number of user creating is required.",
                        digits: "Enter Only Numbers.",
                    },
                    password: {
                        required: "Password is required.",
                    },
                    con_password: {
                        required: "Confirm password is required.",
                        equalTo: "Confirm password is not same as password."
                    },
                    logo: {
                        extension: "Please upload a valid file for logo.",
                    },
                    expiry_date: {
                        dateISO: "Expiry date format is invalid, Expiry date formate like 2000-12-31 (yy-mm-dd)."
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

            //logo view
            $("#logo").change(function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $("#view").html('<img src="' + e.target
                            .result +
                            '" alt="Logo File Preview" width="150">');
                    };
                    reader.readAsDataURL(file);
                } else {
                    $("#view").html("");
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
                var input = $("#con_password");
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
@endsection
