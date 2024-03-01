<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @include('cdn')
</head>

<body>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>


    <form action="{{route('checktoken')}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
            <div class="col-md-6">
                <input type="text" id="email_address" class="form-control" name="email" required autofocus>
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
            <div class="col-md-6">
                <input type="password" id="password" class="form-control" name="password" required autofocus>

            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
            <div class="col-md-6">
                <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>

            </div>
        </div>
        <div class="col-md-6 offset-md-4">
            <input type="submit" class="btn btn-primary" name="Reset Password">
        </div>
    </form>
</body>
</html>