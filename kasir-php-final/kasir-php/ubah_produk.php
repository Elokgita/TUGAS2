<?php
$id = isset($_GET['id'])?intval($_GET['id']):0;
if (!$id) { echo "<script>alert('ID tidak valid');location.href='?page=produk'</script>"; exit; }
if (isset($_POST['nama_produk'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga = intval($_POST['harga_produk']);
    $stok = intval($_POST['stok_produk']);
    $q = mysqli_query($koneksi, "UPDATE tb_produk SET nama_produk='$nama', harga_produk=$harga, stok_produk=$stok WHERE id_produk=$id");
    if ($q) { echo "<script>alert('Data berhasil diubah');location.href='?page=produk'</script>"; }
    else { echo "<script>alert('Gagal: ".mysqli_error($koneksi)."')</script>"; }
}
$r = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE id_produk=$id");
if (mysqli_num_rows($r)==0) { echo "<script>alert('Data tidak ditemukan');location.href='?page=produk'</script>"; exit; }
$data = mysqli_fetch_assoc($r);
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Ubah Produk</h1>
    <form method="post" action="">
        <table class="table">
            <tr><td>Nama Produk</td><td>:</td><td><input class="form-control" type="text" name="nama_produk" value="<?php echo htmlspecialchars($data['nama_produk']); ?>" required></td></tr>
            <tr><td>Harga</td><td>:</td><td><input class="form-control" type="number" name="harga_produk" value="<?php echo htmlspecialchars($data['harga_produk']); ?>" required></td></tr>
            <tr><td>Stok</td><td>:</td><td><input class="form-control" type="number" name="stok_produk" value="<?php echo htmlspecialchars($data['stok_produk']); ?>" required></td></tr>
            <tr><td></td><td></td><td><button class="btn btn-primary" type="submit">Simpan</button> <a class="btn btn-secondary" href="?page=produk">Batal</a></td></tr>
        </table>
    </form>
</div>
