<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to IFFI</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <p>Hi {{ $data['client_name'] }}</p>
    <p>
        Thanks for joining the International Film Festival of India (IFFI).
        This email confirms your payment.
    </p>
    <p>Now you can explore the exciting resources and services IFFI offers. Head over to our website.</p>
    <p><a href="http://www.iffigoa.org/"
            style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Visit
            Now</a></p>
    <p>Thanks<br>NFDC</p>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
