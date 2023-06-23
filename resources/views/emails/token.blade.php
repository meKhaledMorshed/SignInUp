<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Token Email View</title>
</head>

<body>
    <h1>Hello {{ $receiverName }} !</h1>
    <p>Please use below token for verification.</p>
    <p>Your token is <b>{{ $token }}</b></p>
    </br> </br> </br>
    <p>With Regards</p>
    <p><b>{{ $senderName }}</b></p>

</body>

</html>