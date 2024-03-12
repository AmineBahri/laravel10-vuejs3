<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reset Password</title>
    <style>
        .body{
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f8f8f8;
        }
    </style>
    
</head>
@vite('resources/js/app.js')
<body id="page-top">
    <div class="card">
        <div class="title">Demande changement mot de passe</div>
        <div class="subtitle">pour {{$name}}</div>
        <p>
            email envoyé pour changer mot de passe
        </p>
        <a class="reset-link" href="{{url('reset-password-form?token='.$token)}}">Changer mot de passe</a>
    </div>
</body>
</html>