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
                                    <h5 class="card-title">View {{ $modulename }}</h5>
                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>
                        </div>
                        <form id="add" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body mt-4">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label for="client_id">Client id<spna class="text-danger">*</spna></label>
                                        <input type="text" name="client_id" id="client_id" class="form-control"
                                            value="{{ $data->client_id }}" placeholder="Enter Client id" readonly disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name">Name<spna class="text-danger">*</spna></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Enter Name" value="{{ $data->name }}" disabled>
                                    </div>
                                </div>
                                <div class="row mb-2">

                                    <div class="col-md-6">
                                        <label for="mobile_no">Mobile Number<spna class="text-danger">*</spna></label>
                                        <input type="text" maxlength="10" name="mobile_no" id="mobile_no"
                                            class="form-control" placeholder="Enter Mobile Number"
                                            value="{{ $data->mobile_no }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email">Email<spna class="text-danger">*</spna></label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            placeholder="Enter Email Address" value="{{ $data->email }}" disabled>
                                    </div>
                                </div>
                                <div class="row  mb-2">

                                    <div class="col-md-6">
                                        <label for="expiry_date">Expiry Date<spna class="text-danger">*</spna></label>
                                        <input type="Date" name="expiry_date" id="expiry_date" class="form-control"
                                            placeholder="Enter Name" value="{{ $data->expiry_date }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="number_of_users">Number of user creating<spna class="text-danger">*
                                            </spna>
                                        </label>
                                        <input type="text" name="number_of_users" id="number_of_users"
                                            class="form-control" placeholder="Enter Number Of User Creating"
                                            value="{{ $data->number_of_users }}" disabled>
                                    </div>
                                </div>
                                {{-- <div class="row  mb-2">
                                    <div class="col-md-6">
                                        <label for="password">Password<spna class="text-danger">*</spna></label>
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
                                        <label for="con_password">Confirm Password<spna class="text-danger">*</spna></label>
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
                                </div> --}}
                                <div class="row  mb-2">
                                    <div class="col-md-6">
                                        <label for="address">Address<spna class="text-danger">*</spna></label>
                                        <textarea name="address" id="address" class="form-control" placeholder="Enter Address" disabled>{{ $data->address }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="logo">Logo ( jpeg|jpg|png|webp )<spna class="text-danger">*
                                            </spna>
                                        </label>
                                        <input type="file" name="logo" id="logo" class="form-control" disabled>
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
    <script></script>
@endsection
