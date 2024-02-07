<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "handphone");
if (!isset($_SESSION['username'])) {
    header('location:login.php');
}
if (isset($_POST["add"])) {
    if (isset($_SESSION["cart"])) {
        $item_array_id = array_column($_SESSION["cart"], "id_pembeli");
        if (!in_array($_GET["id"], $item_array_id)) {
            $count = count($_SESSION['cart']);
            $item_array = array(
                'id_pembeli' => $_GET["id"],
                'produk' => $_POST["produk"],
                'nama' => $_POST["nama"],
                'harga' => $_POST["harga"],
                'item_quantity' => $_POST["quantity"],
            );
            $_SESSION["cart"][$count] = $item_array;
            echo '<script>alert("Produk berhasil dimasukan keranjang")</script>';
            echo '<script>window.location="eflyer-master/perulangan.php"</script>';
        } else {
            echo '<script>alert("Produk berhasil dimasukan keranjang")</script>';
            echo '<script>window.location="eflyer-master/perulangan.php"</script>';
        }
    } else {
        $item_array = array(
            'id_pembeli' => $_GET["id"],
            'produk' => $_POST["produk"],
            'nama' => $_POST["nama"],
            'harga' => $_POST["harga"],
            'item_quantity' => $_POST["quantity"],
        );
        $_SESSION["cart"][0] = $item_array;
    }
}
if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        foreach ($_SESSION["cart"] as $keys => $value) {
            if ($value["id_pembeli"] == $_GET["id"]) {
                unset($_SESSION["cart"][$keys]);
                echo '<script>alert("Product has been Removed...!")</script>';
                echo '<script>window.location="eflyer-master/perulangan.php"</script>';
            }
        }
    } elseif ($_GET["action"] == "beli") {

        if (isset($_POST['submit'])) {
            $total = 0;
            foreach ($_SESSION["cart"] as $key => $value) {
                $total = $total + ($value["item_quantity"] * $value["harga"]);
                $ppn = $total * 10 / 100;
                $subtotal = $total + $ppn;
            }
            $id_pembeli = $_POST['id_user'];
            $alamat = $_POST['alamat'];
            $query = mysqli_query($koneksi, "INSERT INTO checkout(id_user,alamat,tgl,total) VALUE ('$id_pembeli','$alamat','" . date("Y-m-d") . "','$subtotal')");
        }
        $id_transaksi = mysqli_insert_id($koneksi);
        try {
            foreach ($_SESSION["cart"] as $key => $value) {
                $id_barang = $value['id_pembeli'];
                $quantity = $value['item_quantity'];
                $sql = "INSERT INTO detail VALUES ('','$id_transaksi','$quantity','$id_barang')";
                $res = mysqli_query($koneksi, $sql);
            }
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
        unset($_SESSION["cart"]);
        echo '<script>alert("Terima kasih sudah berbelanja!")</script>';
        echo "<script>window.location='cetak.php?id=" . $id_transaksi . "'</script>";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="cart.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="container mt-5 p-3 rounded cart">
        <div class="row no-gutters">
            <div class="col-md-8">
                <div class="product-details mr-2">
                    <div class="d-flex flex-row align-items-center"> <a href="eflyer-master/perulangan.php"><i
                                class="fa fa-long-arrow-left"></a></i><span class="ml-2">Continue Shopping</span></div>
                    <hr>
                    <h6 class="mb-0">Shopping cart</h6>
                    <div class="d-flex justify-content-between"><span></span>
                        <div class="d-flex flex-row align-items-center"><span class="text-black-50">Sort by:</span>
                            <div class="price ml-2"><span class="mr-1">price</span><i class="fa fa-angle-down"></i>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (!empty($_SESSION["cart"])) {
                        $total = 0;
                        foreach ($_SESSION["cart"] as $key => $value) {
                            ?>
                            <div class="d-flex justify-content-between align-items-center mt-3 p-2 items rounded">
                                <div class="d-flex flex-row">
                                    <img class="rounded" src="img/<?php echo $value["produk"]; ?>" width="40px">
                                    <div class="ml-2"><span class="font-weight-bold d-block">
                                            <?php echo $value["nama"]; ?>
                                        </span><span class="spec"></span></div>
                                </div>
                                <div class="d-flex flex-row align-items-center">
                                    <span class="d-block">
                                        <?php echo $value["item_quantity"]; ?>
                                    </span>
                                    <span class="d-block ml-5 font-weight-bold">
                                        <?php echo number_format($value["harga"]); ?>
                                    </span>
                                    <a href="cart.php?action=delete&id=<?= $value['id_pembeli'] ?>"><i
                                            class="fa fa-trash-o ml-3 text-black-50"></i></a>
                                </div>

                            </div>
                           
                            <?php try{
                                $sub= $value['item_quantity'] *
                                $value['harga'];
                                echo $sub;
                            }catch(exception $e){
                                echo 'massage: '.$e->getmassage();
                            }
                            $total = $total + $sub;
                            
                        }
                     ?>

                </div>
            </div>
            <div class="col-md-4">
                <div class="payment-info">
                    <div class="d-flex justify-content-between align-items-center"><span>Card details</span><img
                            class="rounded" src="https://i.imgur.com/WU501C8.jpg" width="30"></div><span
                        class="type d-block mt-3 mb-1">Card type</span><label class="radio"> <input type="radio"
                            name="card" value="payment" checked> <span><img width="30"
                                src="https://img.icons8.com/color/48/000000/mastercard.png" /></span> </label>

                    <label class="radio"> <input type="radio" name="card" value="payment"> <span><img width="30"
                                src="https://img.icons8.com/officel/48/000000/visa.png" /></span> </label>

                    <label class="radio"> <input type="radio" name="card" value="payment"> <span><img width="30"
                                src="https://img.icons8.com/ultraviolet/48/000000/amex.png" /></span> </label>


                    <label class="radio"> <input type="radio" name="card" value="payment"> <span><img width="30"
                                src="https://i mg.icons8.com/officel/48/000000/paypal.png" /></span> </label>
                    <?php
                    $query = "select * from login where username='$_SESSION[username]'";
                    $r = mysqli_query($koneksi, $query);
                    while ($list = mysqli_fetch_array($r)) {
                        $nama_pembeli = $list['username'];
                        $id_pembeli = $list['id_user'];
                    }
                    ?>
                    <form action="cart.php?action=beli" method="post">
                        <div>
                            <label class="credit-card-label">Name</label>
                            <input type="text" class="form-control credit-inputs" name="nama" placeholder="Name"
                                value="<?= $nama_pembeli ?>">
                            <input type="hidden" name="id_user" value="<?= $id_pembeli ?>">
                        </div>
                        <div><label class="credit-card-label">Adress</label><input type="text"
                                class="form-control credit-inputs" name="alamat"
                                placeholder="Isi dengan alamat lengkap " autofocus required></div>
                        <hr class="line">
                        <div class="d-flex justify-content-between information"><span>Subtotal</span><span>Rp.
                                <?php echo number_format($total) ?>
                            </span></div>
                       
                                
                            </span></div>
                            
                        <input type="submit" class="btn btn-primary btn-block d-flex justify-content-between mt-3"
                            name="submit" value="Rp.<?php echo number_format($total); ?> Checkout">
                        </input>
                        <?php }?>
                </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>