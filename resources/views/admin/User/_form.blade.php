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
                                        <input type="hidden" value="{{ $data->id }}" id="user_id" name="user_id">
                                    </div>
                                    <div class="col-md-12">
                                        <input type="hidden" value="{{ $data->client_id }}" id="client_id"
                                            name="client_id">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label for="role">Role<spna class="text-danger">*</spna></label>
                                        <select class="form-control roles" id="role" name="role" disabled>
                                            <option></option>

                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    @role('user|client') {{ $data->roles->contains($role) ? 'selected' : '' }} {{ $role->id == 3 || $role->id == 1 ? 'disabled' : '' }}
                                                @else {{ $data->roles->contains($role) ? 'selected' : '' }}  @endrole>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name">Name<spna class="text-danger">*</spna></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Enter Name" value="{{ $data->name }}">
                                    </div>
                                </div>
                                <div class="row  mb-2">
                                    <div class="col-md-6">
                                        <label for="mobile_no">Mobile Number<spna class="text-danger">*</spna></label>
                                        <input type="text" maxlength="10" name="mobile_no" id="mobile_no"
                                            class="form-control" placeholder="Enter Mobile Number"
                                            value="{{ $data->mobile_no }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="expiry_date">Expiry Date</label>
                                        <input type="text" name="expiry_date" id="expiry_date" class="form-control"
                                            placeholder="Enter Name" value="{{ $data->expiry_date }}" autocomplete="off">
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
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <label>Permission</label>
                                        <div class="col-12 mt-2">
                                            <div class="row">
                                                @foreach ($permissions as $model => $modelPermissions)
                                                    @role('client|user')
                                                        @if ($model != 'Client' && $model != 'User')
                                                            <div class="card w-25">
                                                                <div class="card-header">
                                                                    <div class="icheck-primary d-inline ms-1">
                                                                        @php
                                                                            $allPermissionsChecked = true;
                                                                        @endphp
                                                                        @foreach ($modelPermissions as $permission)
                                                                            @unless (in_array($permission->id, $approved))
                                                                                @php
                                                                                    $allPermissionsChecked = false;
                                                                                @endphp
                                                                            @break
                                                                        @endunless
                                                                    @endforeach
                                                                    <input type="checkbox" class="checkModel"
                                                                        id="content{{ $model }}"
                                                                        data-model="{{ $model }}"
                                                                        {{ $allPermissionsChecked ? 'checked' : '' }}>
                                                                    <label for="content{{ $model }}"
                                                                        class="text-dark">{{ $model }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="card-body mt-3">
                                                                @foreach ($modelPermissions as $permission)
                                                                    <div class="icheck-primary d-inline">
                                                                        <input type="checkbox" class="chk"
                                                                            id="content{{ $permission->id }}"
                                                                            name="permission[]"
                                                                            data-model="{{ $model }}"
                                                                            value="{{ $permission->id }}"
                                                                            {{ in_array($permission->id, $approved) ? 'checked' : '' }}>
                                                                        <label
                                                                            for="content{{ $permission->id }}">{{ $permission->description }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="card w-25">
                                                        <div class="card-header">
                                                            <div class="icheck-primary d-inline ms-1">
                                                                @php
                                                                    $allPermissionsChecked = true;
                                                                @endphp
                                                                @foreach ($modelPermissions as $permission)
                                                                    @unless (in_array($permission->id, $approved))
                                                                        @php
                                                                            $allPermissionsChecked = false;
                                                                        @endphp
                                                                    @break
                                                                @endunless
                                                            @endforeach
                                                            <input type="checkbox" class="checkModel"
                                                                id="content{{ $model }}"
                                                                data-model="{{ $model }}"
                                                                {{ $allPermissionsChecked ? 'checked' : '' }}>
                                                            <label for="content{{ $model }}"
                                                                class="text-dark">{{ $model }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="card-body mt-3">
                                                        @foreach ($modelPermissions as $permission)
                                                            <div class="icheck-primary d-inline">
                                                                <input type="checkbox" class="chk"
                                                                    id="content{{ $permission->id }}"
                                                                    name="permission[]"
                                                                    data-model="{{ $model }}"
                                                                    value="{{ $permission->id }}"
                                                                    {{ in_array($permission->id, $approved) ? 'checked' : '' }}>
                                                                <label
                                                                    for="content{{ $permission->id }}">{{ $permission->description }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endrole
                                        @endforeach
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
        $(".checkModel").change(function() {
            const model = $(this).data('model');
            $(`.chk[data-model="${model}"]`).prop('checked', $(this).prop("checked"));
        });

        // Check/uncheck the model checkbox when all related checkboxes are checked/unchecked
        $(".chk").change(function() {
            const model = $(this).data('model');
            const allChecked = $(`.chk[data-model="${model}"]:checked`).length === $(
                `.chk[data-model="${model}"]`).length;
            $(`.checkModel[data-model="${model}"]`).prop('checked', allChecked);
        });

        $(".roles").select2({
            placeholder: "Select user role",
            allowClear: true,
            theme: 'bootstrap4'
        });

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
                role: {
                    required: true,
                },
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
                con_password: {
                    equalTo: "#password"
                },
                expiry_date: {
                    dateISO: true
                }
            },
            messages: {
                role: {
                    required: "Role is required.",
                },
                name: {
                    required: "Name is required.",
                },
                mobile_no: {
                    required: "Mobile number is required.",
                    digits: "Enter Only Numbers.",
                    remote: "Mobile number already exists !",
                },
                expiry_date: {
                    dateISO: "Expiry date format is invalid, Expiry date formate like 2000-12-31 (yy-mm-dd)."
                },
                con_password: {
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

        var selectedRole = $(".roles").val();

        // Show/hide permission models based on the selected role
        if (selectedRole == 2) {
            $('[data-model="Client"], [data-model="User"]').closest('.card').hide();
        } else if (selectedRole == 3) {
            $('[data-model="Client"]').closest('.card').hide();
        } else {
            $('[data-model="Client"], [data-model="User"]').closest('.card').show();
        }

    });
</script>
@endsection
