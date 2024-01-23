<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Pages / Login - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('public/admin/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('public/admin/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('public/admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/admin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('public/admin/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/admin/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('public/admin/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('public/admin/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('public/admin/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('public/admin/css/style.css') }}" rel="stylesheet">


</head>

<body>

    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="{{ asset('public/admin/img/logo.png') }}" alt="">
                                    <span class="d-none d-lg-block">NiceAdmin</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card w-100 mb-3">

                                <div class="card-body pt-4 pb-4">



                                    <form method="POST" id="login" action="{{ route('login') }}">
                                        @csrf


                                        <div class="col-md-12">
                                            <label for="mobile_no" class="form-label">Mobile Number</label>
                                            <div class="input-group">
                                                <input type="text" name="mobile_no" maxlength="10"
                                                    class="form-control" id="mobile_no">
                                                <span class="input-group-text" id="inputGroupPrepend"> <i
                                                        class="bi bi-phone"></i></span>
                                                <div class="col-md-12"></div>
                                                @error('mobile_no')
                                                    <span style="color: red;"> {{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="password">

                                        </div>


                                        <div class="col-12 mt-3">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>

                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->

    <script src="{{ asset('public/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/admin/js/validate.min.js') }}"></script>
    <script src="{{ asset('public/admin/js/additional.min.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('public/admin/js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#login").validate({
                rules: {
                    password: {
                        required: true,
                    },
                    mobile_no: {
                        required: true,
                        minlength: 10,
                        digits: true,
                    }
                },
                messages: {
                    password: {
                        required: "Password is required.",
                    },
                    mobile_no: {
                        required: "Mobile no is required.",
                        digits: "Enter Only Numbers.",
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
        });
    </script>
</body>

</html>
