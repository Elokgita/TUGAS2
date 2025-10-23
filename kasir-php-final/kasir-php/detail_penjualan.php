<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) {
    echo "<script>alert('ID tidak valid');location.href='?page=penjualan_detail'</script>";
    exit;
}

$r = mysqli_query($koneksi, "
    SELECT p.*, pl.nama_pelanggan 
    FROM tb_penjualan p 
    LEFT JOIN tb_pelanggan pl ON p.id_pelanggan = pl.id_pelanggan 
    WHERE p.id_penjualan = $id
");

if (mysqli_num_rows($r) == 0) {
    echo "<script>alert('Data tidak ditemukan');location.href='?page=penjualan_detail'</script>";
    exit;
}

$data = mysqli_fetch_assoc($r);

$items = mysqli_query($koneksi, "
    SELECT d.*, pr.nama_produk, pr.harga_produk 
    FROM tb_detailpenjualan d 
    JOIN tb_produk pr ON d.id_produk = pr.id_produk 
    WHERE d.id_penjualan = $id
");
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Detail Penjualan #<?php echo $data['id_penjualan']; ?></h1>
    <p>Tanggal: <?php echo $data['tanggal_penjualan']; ?></p>
    <p>Pelanggan: <?php echo htmlspecialchars($data['nama_pelanggan']); ?></p>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>

        <?php 
        $no = 1;
        $total = 0;
        while ($it = mysqli_fetch_assoc($items)) { ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($it['nama_produk']); ?></td>
                <td><?php echo number_format($it['harga_produk']); ?></td>
                <td><?php echo $it['jumlah_produk']; ?></td>
                <td><?php echo number_format($it['sub_total']); ?></td>
            </tr>
        <?php 
            $total += $it['sub_total'];
        } ?>
        <tr>
            <td colspan="4"><strong>Total</strong></td>
            <td><strong><?php echo number_format($total); ?></strong></td>
        </tr>
    </table>

    <a class="btn btn-secondary" href="?page=penjualan_detail">Kembali</a>
</div>
