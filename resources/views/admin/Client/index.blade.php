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
                                <div class="col-md-6">
                                    @permission('create.client')
                                        <a href="{{ route('create.client') }}" class="btn btn-primary mt-3 float-end">
                                            <i class="fa-solid fa-plus"></i> Add Client
                                        </a>
                                    @endpermission
                                </div>
                            </div>
                        </div>
                        <div class="card-body mt-4 ">

                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Client id</th>
                                        <th>Name</th>
                                        <th>Mobile Number</th>
                                        <th>Logo</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Expiry Date</th>
                                        <th>User</th>
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

        $(document).ready(function() {
            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('client') }}",
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
                        data: 'name',
                        searchable: true,
                    },
                    {
                        data: 'mobile_no',
                        searchable: true,
                    },
                    {
                        data: 'logo',
                        searchable: false,
                    },
                    {
                        data: 'email',
                        searchable: true,
                    },
                    {
                        data: 'address',
                        searchable: true,
                    },
                    {
                        data: 'expiry_date',
                        searchable: true,
                    },
                    {
                        data: 'number_of_users',
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
                    text: "Are you sure you want to delete this client.",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "get",
                            url: "{{ route('delete.client') }}",
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
        });
    </script>
@endsection
