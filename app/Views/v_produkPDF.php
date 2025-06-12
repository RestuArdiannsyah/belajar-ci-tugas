<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 30px;
        }

        th {
            background-color: rgb(41, 41, 41);
            padding: 12px;
            text-align: center;
            color: white;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        img {
            border-radius: 5px;
        }

        .download-info {
            text-align: right;
            color: #666;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <h1>Data Produk</h1>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Foto</th>
        </tr>

        <?php
        $no = 1;
        foreach ($product as $index => $produk) :
            $path = "../public/img/" . $produk['foto'];
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        ?>
            <tr>
                <td align="center"><?= $index + 1 ?></td>
                <td><?= $produk['nama'] ?></td>
                <td align="right"><?= "Rp " . number_format($produk['harga'], 2, ",", ".") ?></td>
                <td align="center"><?= $produk['jumlah'] ?></td>
                <td align="center">
                    <img src="<?= $base64 ?>" width="50px">
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="download-info">
        Downloaded on <?= date("Y-m-d H:i:s") ?>
    </div>

    <div class="footer">
        &copy; <?= date("Y") ?> Zaybela. All rights reserved.
    </div>
</body>

</html>