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
        {{ __('This is a secure area of the application. Please click on link to reset your password .') }}
    </div>
    <div>
        @php
        $token = $token['token'] ;
        $email = $email['email'] ;
        @endphp
        <a href="{{route('resetpassword',['token'=>$token,'email'=>$email])}}" class="btn btn-sm btn-dark">click here</a>

    </div>
</body>

</html>