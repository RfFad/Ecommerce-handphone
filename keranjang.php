<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produk</title>
</head>
<body>

    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Harga</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
                include "konek.php";
                $no = 1;
                $sql = "SELECT * FROM produk";
                $query = mysqli_query($konek, $sql);
                while($data = mysqli_fetch_array($query)){?>
                    
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $data["nama_produk"]; ?></td>
                        <td><?php echo $data["harga"]; ?></td>
                        <td><a href="tambah.php?id=<?php echo $data["id_produk"];?>">Tambah</td>
                    </tr>

                    <?php $no++; ?>
                <?php }
            ?>
            
        </tbody>
    </table>

</body>
</html>