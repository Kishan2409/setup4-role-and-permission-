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
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" value="{{ $data->id }}" id="user_id" name="user_id"
                                            disabled>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label for="role">Role<spna class="text-danger">*</spna></label>
                                        <select class="form-control roles" id="role" name="role" disabled>
                                            <option></option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ $data->roles->contains($role) ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name">Name<spna class="text-danger">*</spna></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Enter Name" value="{{ $data->name }}" disabled>
                                    </div>

                                </div>
                                <div class="row  mb-2">
                                    <div class="col-md-6">
                                        <label for="mobile_no">Mobile Number<spna class="text-danger">*</spna></label>
                                        <input type="text" maxlength="10" name="mobile_no" id="mobile_no"
                                            class="form-control" placeholder="Enter Mobile Number"
                                            value="{{ $data->mobile_no }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="expiry_date">Expiry Date<spna class="text-danger">*</spna></label>
                                        <input type="Date" name="expiry_date" id="expiry_date" class="form-control"
                                            placeholder="Enter Name" value="{{ $data->expiry_date }}" disabled>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <label>Permission</label>
                                        <div class="col-12 mt-2">
                                            <div class="row">
                                                @foreach ($permissions as $model => $modelPermissions)
                                                    @role('client|user')
                                                        @if ($model != 'Client')
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
    });
</script>
@endsection
