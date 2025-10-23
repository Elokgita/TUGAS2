<?php
if (isset($_POST['nama_produk'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga = intval($_POST['harga_produk']);
    $stok = intval($_POST['stok_produk']);
    $q = mysqli_query($koneksi, "INSERT INTO tb_produk(nama_produk, harga_produk, stok_produk) VALUES('$nama', $harga, $stok)");
    if ($q) {
        echo "<script>alert('Produk berhasil ditambahkan');location.href='?page=produk'</script>";
    } else {
        echo "<script>alert('Gagal: ".mysqli_error($koneksi)."')</script>";
    }
}
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Produk</h1>
    <form method="post" action="">
        <table class="table">
            <tr><td>Nama Produk</td><td>:</td><td><input class="form-control" type="text" name="nama_produk" required></td></tr>
            <tr><td>Harga</td><td>:</td><td><input class="form-control" type="number" name="harga_produk" required></td></tr>
            <tr><td>Stok</td><td>:</td><td><input class="form-control" type="number" name="stok_produk" required></td></tr>
            <tr><td></td><td></td><td><button class="btn btn-primary" type="submit">Simpan</button> <a class="btn btn-secondary" href="?page=produk">Batal</a></td></tr>
        </table>
    </form>
</div>
