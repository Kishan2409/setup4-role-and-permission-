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
                                    @if (auth()->user()->hasRole('superadmin'))
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="Roles">
                                                    <lable for="roles" class="card-title m-1">Select Role</lable>
                                                    <select class="select2 w-100" name="roles" id="roles">
                                                        <option value=""></option>
                                                        <option value="1">Superadmin</option>
                                                        <option value="2">User</option>
                                                        <option value="3">Client</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="ml-3 mt-4 Filter">
                                                    <button class="btn border border-danger text-black" id="clearfilter"><i
                                                            class="fa-solid fa-filter-circle-xmark"></i> Clear
                                                        Filter</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    @role('superadmin')
                                        <a href="{{ route('create.user') }}" class="btn btn-primary mt-3 float-end">
                                            <i class="fa-solid fa-plus"></i> Add {{ $modulename }}
                                        </a>
                                    @else
                                        @permission('create.user')
                                            <a href="{{ route('create.user') }}" class="btn btn-primary mt-3 float-end">
                                                <i class="fa-solid fa-plus"></i> Add {{ $modulename }}
                                            </a>
                                        @endpermission
                                    @endrole
                                </div>
                            </div>
                        </div>
                        <div class="card-body mt-4 ">

                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Client id</th>
                                        <th>User Role</th>
                                        <th>Name</th>
                                        <th>Mobile Number</th>
                                        <th>Expiry Date</th>
                                        <th>Added by</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
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

        @if (session('error'))
            Swal.fire({
                title: "Error",
                text: "{{ Session::get('error') }}",
                icon: 'error',
                showCloseButton: true,
                confirmButtonText: 'OK',
            });
        @endif

        $(document).ready(function() {
            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('user') }}",
                    data: function(d) {
                        d.roles = $('#roles').val()
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'client_id',
                        searchable: true,
                    },
                    {
                        data: 'userrole',
                        searchable: true,
                    },
                    {
                        data: 'name',
                        searchable: true,
                    },
                    {
                        data: 'mobile_no',
                        searchable: true,
                    },
                    {
                        data: 'expiry_date',
                        searchable: true,
                    },
                    {
                        data: 'added_by',
                        searchable: true,
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            // delete btn
            $("#example").on('click', '.delete', function(e) {
                e.preventDefault();
                var input = $(this);
                var Id = input.data("id")

                Swal.fire({
                    title: "Are you sure ?",
                    text: "Are you sure you want to delete this user.",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "get",
                            url: "{{ route('delete.user') }}",
                            data: {
                                'id': Id,
                            },
                            success: function(Id) {
                                table.ajax.reload();
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            }
                        });
                    }
                })
            });
            // status filter
            $('#roles').change(function() {
                table.draw();
            });

            // clearfilter
            $("#clearfilter").click(function() {
                $('#roles').val(null).trigger('change');
            });
            // select2 dropdown
            $('.select2').select2({
                placeholder: "--- Select Role ---",
                theme: 'bootstrap4',
            });
        });
    </script>
@endsection
