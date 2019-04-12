<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TDH Online</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('/back') }}/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('/back') }}/css/AdminLTE.min.css">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/login') }}"><b>TDH</b> Online</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <?php $status = session('status'); ?>
        @if(session('status')=='save')
            <div class="alert alert-info text-center">
                <i class="fa fa-user"></i> Registered Successfully. Please <a href="{{ url('login') }}">sign-in</a> to your account.
            </div>
        @elseif($status=='duplicate')
            <div class="alert alert-warning text-center">
                <i class="fa fa-warning"></i> Registration Failed! Please use different username.
            </div>
        @endif
        <p class="login-box-msg">Register a new membership</p>

        <form action="{{ url('register') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="First Name" name="fname" required>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Last Name" name="lname" required>
            </div>
            <div class="form-group has-feedback">
                <select id="sex" name="sex" class="form-control" required>
                    <option value="">Select Gender...</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>
            <div class="form-group has-feedback">
                <input type="date" class="form-control" placeholder="mm/dd/yyyy" title="Birthday" name="dob" required>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Contact #" name="contact" required>
            </div>
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Email Address" name="email">
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Complete Address" name="address" required>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Designation" name="position" required>
            </div>
            <div class="form-group has-feedback">
                <select name="section" class="form-control" required>
                    <option value="">Select Section...</option>
                    @foreach($sections as $row)
                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Username" name="username" required>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password" required minlength="6">
            </div>
            <div class="form-group">
                <div class="picture">
                    <input type='file' required class="form-control" placeholder="Profile Picture" name="picture" onchange="readProfURL(this);" />
                    <img id="prof_pic" src="{{ asset('back/img/default.jpg') }}" width="100%" height="" />

                </div>
            </div>
            <div class="row" style="border-top: 1px solid #ccc; padding-top:10px;">
                <div class="col-xs-8">

                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <hr />
        <a href="{{ url('/') }}" class="text-center"><i class="glyphicon glyphicon-arrow-left"></i> Back to Homepage</a><br />
        <a href="{{ url('/login') }}" class="text-center">I already have a membership</a>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="back/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="back/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script>
    function readProfURL(input)
    {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#prof_pic').attr('src', e.target.result);
                $('#prof_pic').addClass('img-responsive');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</body>
</html>
