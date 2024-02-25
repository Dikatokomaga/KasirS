<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background-color: #2980b9;
        }

        p {
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Reset Password</h1>
        <br>
        <p>You have requested to reset your password. Click the link below to reset your password:</p>
        <a href="{{ route('validasi_forgot_password', ['token' => $token]) }}">Reset Password</a>
    </div>
</body>

</html>
