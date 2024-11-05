<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Kode</title>
    <style>
        * {
            margin: 2px;
            padding: 2px;
        }

        .layout-qrcode {
            display: inline-flex;
            text-align: center;
            transform: rotate(-90deg);
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div class="layout-qrcode">
        <img src="data:image/png;base64, {!! base64_encode(QrCode::size(60)->generate($kode)) !!} ">
        <p>{{ $kode }}</p>
    </div>
</body>

</html>
