<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>API | KASIR</title>
    <style>
        .border {
            border: 1px solid black;
            width: 520px;
        }
    </style>
</head>

<body>
    <h1>API KASIR</h1>

    <p>POST | http://127.0.0.1:8000/api/register</p>
    <p>POST | http://127.0.0.1:8000/api/login</p>

    <h3>Harus Menggunakan Bearer Token</h3>
    <h5>Bearer Token diambil dari token setelah login</h5>
    <p>Contoh : Bearer Token <input type="text" placeholder="7|TDc54RuAuf1o2khRsmW2d7RVYCfk4bxIKW9fk0lTa0f76488"></p>
    <div class="border">
        <h3>API Get Produk</h3>
        <p>GET | http://127.0.0.1:8000/api/produk</p>

        <h3>API Search Produk</h3>
        <p>GET | http://127.0.0.1:8000/api/produk?filter[nama]=Nabati</p>

        <h3>API Profile</h3>
        <p>GET | http://127.0.0.1:8000/api/profile</p>
        <h3>API Transaksi</h3>
        <p>POST | http://127.0.0.1:8000/api/transaksi</p>
        <h3>API Logout</h3>
        <p>GET | http://127.0.0.1:8000/api/logout</p>
    </div>
</body>

</html>
