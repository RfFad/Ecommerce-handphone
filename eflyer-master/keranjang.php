<?php 

session_start();
$koneksi= mysqli_connect("localhost","root","","handphone");
if (isset($_POST["add"])){
    if(isset($_SESSION["cart"]))
    $item_array_id=array_column($_SESSION["cart"],"id_pembeli");
    if(!in_array($_GET["id"],$item_array_id)){
        $count=count($_SESSION["cart"]);
        $item_array=array(
            'id_pembeli' => $_GET["id"],
            'nama' => $_POST["nama"],
            'harga' => $_POST["harga"],
            'produk' => $_POST["produk"],

            
        );
        $_SESSION["cart"][$count]=$item_array;
        echo '<script>alert("Produk Berhasil di Masukan Keranjang")</script>';
        echo '<script>window.location="perulangan.php"</script>';
    }else{
        echo '<script>alert("Produk sudah ada di dalam keranjang")</script>';
        echo '<script>window.location="perulangan.php"</script>';
    }
}else{
    $item_array=array(
        'id_pembeli' => $_GET["id"],
        'nama' => $_POST["nama"],
        'harga' => $_POST["harga"],
        'produk' => $_POST["produk"],
       
        
    );
    $_SESSION["cart"][0]=$item_array;
}

if (isset($_GET["action"])){
    if($_GET["action"]=="delete"){
        foreach($_SESSION["cart"] as $keys => $value ){
            if($value["id_pembeli"] == $_GET["id"]){
                unset($_SESSION["cart"][$keys]);
                echo '<script>alert("Product has been Removed...!")</script>';
                echo '<script>window.location="perulangan.php"</script>';
            }
        }
    }
}



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ranjang.css">
    <title>Document</title>
</head>
<body>
<div class="card">
            <div class="row">
                <div class="col-md-8 cart">
                    <div class="title">
                        <div class="row">
                            <div class="col"><h4><b>Shopping Cart</b></h4></div>
                            <div class="col align-self-center text-right text-muted">3 items</div>
                        </div>
                    </div>    
                    <div class="row border-top border-bottom">
                        <?php 
                       include '../konek.php';
                       $q2=mysqli_query($koneksi,"SELECT * FROM produk WHERE id_pembeli='$_GET[id]'");
                       while($data=mysqli_fetch_array($q2)){
                            
                            
                        ?>
                        <div class="row main align-items-center">
                            <div class="col-2"><img src="../img/<?=$value["produk"]?>"></div>
                            <div class="col">
                        
                                <div class="row text-muted"><?php echo $value["nama"];?></div>
                               
                            </div>
                            <div class="col"><?php echo $value["harga"];?> <span class="close">&#10005;</span></div>
                            <div class="col">
                             rp <?php echo number_format($value["harga"] * 2); ?>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    
                    <div class="back-to-shop"><a href="perulangan.php">&leftarrow;</a><span class="text-muted">Back to shop</span></div>
                </div>
                <div class="col-md-4 summary">
                    <div><h5><b>Summary</b></h5></div>
                    <hr>
                    <div class="row">
                        <div class="col" style="padding-left:0;">ITEMS 3</div>
                        <div class="col text-right">&euro; 132.00</div>
                    </div>
                    
                    <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                        <div class="col">TOTAL PRICE</div>
                        <div class="col text-right">&euro; 137.00</div>
                    </div>
                    <button class="btn">CHECKOUT</button>
                </div>
            </div>
            <?php }?>
        </div>
</body>
</html>