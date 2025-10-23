<?php
if (isset($_POST['tanggal_penjualan'])) {
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal_penjualan']);
    $id_pelanggan = intval($_POST['id_pelanggan']);
    $total = intval($_POST['total_harga']);

    $q = mysqli_query($koneksi, "INSERT INTO tb_penjualan(tanggal_penjualan, total_harga, id_pelanggan) VALUES('$tanggal', $total, $id_pelanggan)");
    if ($q) { echo "<script>alert('Penjualan disimpan');location.href='?page=penjualan'</script>"; }
    else { echo "<script>alert('Gagal: ".mysqli_error($koneksi)."')</script>"; }
}
$pel = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan ORDER BY nama_pelanggan");
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Penjualan (Sederhana)</h1>
    <form method="post" action="">
        <table class="table">
            <tr><td>Tanggal</td><td>:</td><td><input type="date" name="tanggal_penjualan" class="form-control" required></td></tr>
            <tr><td>Pelanggan</td><td>:</td><td>
                <select name="id_pelanggan" class="form-control" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    <?php while($r=mysqli_fetch_assoc($pel)){ ?>
                        <option value="<?php echo $r['id_pelanggan']; ?>"><?php echo htmlspecialchars($r['nama_pelanggan']); ?></option>
                    <?php } ?>
                </select>
            </td></tr>
            <tr><td>Total Harga</td><td>:</td><td><input type="number" name="total_harga" class="form-control" required></td></tr>
            <tr><td></td><td></td><td><button class="btn btn-primary" type="submit">Simpan</button> <a class="btn btn-secondary" href="?page=penjualan">Batal</a></td></tr>
        </table>
    </form>
</div>
