<?php
require "session.php";
require "../koneksi.php";

$query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
$jumlahProduk = mysqli_num_rows($query);
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

function generateRandomString($length = 20){
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Produk</title>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../fontawesome/css/all.min.css">
<style>
    .no-decoration{ text-decoration:none; }
    form div{ margin-bottom:10px; }
</style>
</head>
<body>

<?php require "navbar.php"; ?>

<div class="container mt-5">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../adminpanel" class="no-decoration text-muted"><i class="fa-solid fa-house"></i> Home</a>
            </li>
            <li class="breadcrumb-item active">Produk</li>
        </ol>
    </nav>

    <!-- Tambah Produk -->
    <div class="my-5 col-12 col-md-6">
        <h3>Tambah Produk</h3>

        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" autocomplete="off">
            </div>
            <div>
                <label>Kategori</label>
                <select name="kategori" class="form-control">
                    <option value="">Pilih Satu</option>
                    <?php while($data=mysqli_fetch_array($queryKategori)){ ?>
                        <option value="<?php echo $data['id']; ?>"><?php echo $data['nama']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label>Harga</label>
                <input type="number" name="harga" class="form-control">
            </div>
            <div>
                <label>Foto</label>
                <input type="file" name="foto" class="form-control">
            </div>
            <div>
                <label>Detail</label>
                <textarea name="detail" cols="30" rows="5" class="form-control"></textarea>
            </div>
            <div>
                <label>Ketersediaan Stok</label>
                <select name="ketersediaan_stok" class="form-control">
                    <option value="tersedia">Tersedia</option>
                    <option value="habis">Habis</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
        </form>

        <?php
        if(isset($_POST['simpan'])){
            $nama = htmlspecialchars($_POST['nama']);
            $kategori = htmlspecialchars($_POST['kategori']);
            $harga = htmlspecialchars($_POST['harga']);
            $detail = htmlspecialchars($_POST['detail']);
            $stok = htmlspecialchars($_POST['ketersediaan_stok']);

            if($nama=='' || $kategori=='' || $harga==''){
                echo '<div class="alert alert-warning mt-3">Nama, Kategori & Harga wajib diisi</div>';
            } else {

                $foto = $_FILES['foto']['name'];
                $new_name = "";

                if($foto != ""){
                    $target_dir = "../image/";
                    $ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
                    $size = $_FILES["foto"]["size"];
                    $new_name = generateRandomString().".".$ext;

                    if($size > 1000000){
                        echo '<div class="alert alert-warning mt-3">Ukuran foto maksimal 1MB</div>';
                        exit;
                    }
                    if($ext != "jpg" && $ext != "png"){
                        echo '<div class="alert alert-warning mt-3">Foto wajib bertipe jpg atau png</div>';
                        exit;
                    }
                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir.$new_name);
                }

                $insert = mysqli_query($con,
                "INSERT INTO produk (kategori_id,nama,harga,foto,detail,ketersediaan_stok)
                VALUES('$kategori','$nama','$harga','$new_name','$detail','$stok')");

                echo $insert
                ? '<div class="alert alert-success mt-3">Produk berhasil disimpan</div><meta http-equiv="refresh" content="1; URL=produk.php">'
                : mysqli_error($con);
            }
        }
        ?>
    </div>

    <!-- List Produk -->
    <div class="mt-3 mb-5">
        <h2>List Produk</h2>

        <div class="table-responsive mt-4">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if($jumlahProduk==0){
                    echo '<tr><td colspan="6" class="text-center">Tidak ada data produk</td></tr>';
                } else {
                    $no = 1;
                    while($data=mysqli_fetch_array($query)){
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $data['nama']; ?></td>
                        <td><?php echo $data['nama_kategori']; ?></td>
                        <td><?php echo number_format($data['harga']); ?></td>
                        <td><?php echo $data['ketersediaan_stok']; ?></td>
                        <td>
                            <a href="produk-detail.php?p=<?php echo $data['id']; ?>" class="btn btn-info">
                                <i class="fa-solid fa-search"></i>
                            </a>
                        </td>
                    </tr>
                <?php }} ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src ="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
