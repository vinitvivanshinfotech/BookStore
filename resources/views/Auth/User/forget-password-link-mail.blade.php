<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>reset password</title>
</head>
<body>
    <p> We have received password reset request. 
        Please click on the link below to reset your password.
    </p>
    <a href="{{route('user.enter-new-password-view',['email'=> $data['email'],'token'=>$data['token']])}}">Click here</a>
    
</body>
</html>