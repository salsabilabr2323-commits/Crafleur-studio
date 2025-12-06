<?php
require "session.php";
require "../koneksi.php";

$id = $_GET['p'];

$query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id'");
$data = mysqli_fetch_array($query);
$queryKategori = mysqli_query($con, "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");

function generateRandomString($length = 20){
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Produk Detail</title>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<style> form div{ margin-bottom:10px; } </style>
</head>
<body>

<?php require "navbar.php"; ?>

<div class="container mt-5">
<h2>Detail Produk</h2>

<div class="col-12 col-md-6 mb-5">

 <!-- Hapus Produk -->
<?php
if(isset($_POST['hapus'])){
    unlink("../image/".$data['foto']);                 // hapus foto dari folder
    mysqli_query($con, "DELETE FROM produk WHERE id='$id'"); // hapus data produk

    echo '<div class="alert alert-primary mt-3">Produk Berhasil Dihapus</div>';
    echo '<meta http-equiv="refresh" content="2; URL=produk.php">';
    exit;
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div>
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" value="<?php echo $data['nama'] ?>" class="form-control" required>
    </div>

    <div>
        <label for="kategori">Kategori</label>
        <select name="kategori" id="kategori" class="form-control" required>
            <option value="<?php echo $data['kategori_id']; ?>"><?php echo $data['nama_kategori']; ?></option>
            <?php while($row=mysqli_fetch_array($queryKategori)){ ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
            <?php } ?>
        </select>
    </div>

    <div>
        <label for="harga">Harga</label>
        <input type="number" class="form-control" value="<?php echo $data['harga']; ?>" name="harga" required>
    </div>

    <div>
        <label>Foto Produk Sekarang</label><br>
        <img src="../image/<?php echo $data['foto']?>" width="300px">
    </div>

    <div>
        <label>Foto Baru (opsional)</label>
        <input type="file" name="foto" class="form-control">
    </div>

    <div>
        <label for="detail">Detail</label>
        <textarea name="detail" id="detail" cols="30" rows="7" class="form-control"><?php echo $data['detail']; ?></textarea>
    </div>

    <div>
        <label for="ketersediaan_stok">Ketersediaan Stok</label>
        <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
            <option value="<?php echo $data['ketersediaan_stok']; ?>"><?php echo $data['ketersediaan_stok']; ?></option>
            <option value="<?php echo ($data['ketersediaan_stok']=="tersedia") ? "habis" : "tersedia"; ?>">
                <?php echo ($data['ketersediaan_stok']=="tersedia") ? "Habis" : "Tersedia"; ?>
            </option>
        </select>
    </div>

    <div>
        <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
        <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
    </div>
</form>

 <!-- Update Produk -->
<?php
if(isset($_POST['simpan'])){
    $nama = htmlspecialchars($_POST['nama']);
    $kategori = htmlspecialchars($_POST['kategori']);
    $harga = htmlspecialchars($_POST['harga']);
    $detail = htmlspecialchars($_POST['detail']);
    $stok = htmlspecialchars($_POST['ketersediaan_stok']);

    mysqli_query($con, "UPDATE produk SET kategori_id='$kategori', nama='$nama', harga='$harga', detail='$detail', ketersediaan_stok='$stok' WHERE id='$id'");

    if($_FILES['foto']['name'] != ""){
        $ext = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $random_name = generateRandomString().".".$ext;

        if($ext!='jpg' && $ext!='png'){
            echo '<div class="alert alert-warning mt-3">Foto wajib bertipe JPG/PNG</div>';
            exit;
        }
        if($_FILES['foto']['size'] > 1000000){
            echo '<div class="alert alert-warning mt-3">Ukuran Foto Maksimal 1MB</div>';
            exit;
        }

        move_uploaded_file($_FILES["foto"]["tmp_name"], "../image/".$random_name);
        unlink("../image/".$data['foto']); 

        mysqli_query($con, "UPDATE produk SET foto='$random_name' WHERE id='$id'");
    }

    echo '<div class="alert alert-primary mt-3">Produk Berhasil Diupdate</div>';
    echo '<meta http-equiv="refresh" content="2; URL=produk.php">';
    exit;
}
?>

</div>
</div>

<script src ="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
