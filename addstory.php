<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerita | Tambah Cerita</title>
    <style>
        body {
            background-color: #d3f5cf; /* Warna latar belakang hijau cerah */
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        fieldset {
            width: 300px;
            padding: 15px;
            background-color: #fff; /* Warna latar belakang putih */
            border: 1px solid #ccc; /* Garis tepi abu-abu */
            border-radius: 6px;
        }

        legend {
            font-weight: bold;
            font-size: 24px;
        }

        label {
            font-weight: bold;
        }

        .btnSimpan {
            background-color: #2db74f; /* Warna hijau cerah */
            border: none;
            color: #fff;
            padding: 6px 10px;
            text-align: center;
            font-size: 14px;
            border-radius: 6px;
            transition-duration: 0.4s;
            text-decoration: none;
            float: right;
            margin-top: 5px;
        }

        .btnSimpan:hover {
            background: #228941; /* Warna hijau cerah saat dihover */
        }
    </style>
</head>

<body>
    <fieldset>
        <legend>Tambah Cerita</legend>
        <form method="post" enctype="multipart/form-data" action="addstory_proses.php" autocomplete="off">
            <label>Judul:</label><br>
            <input type="text" name="judul"><br><br>
            <label>Paragraf:</label>
            <textarea name="paragraf" cols="40" rows="8"></textarea><br>
            <button name="simpan" class="btnSimpan">Simpan</button>
        </form>
    </fieldset>
</body>

</html>