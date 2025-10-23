<?php
// tampilkan penjualan dengan detail (menggabungkan tb_penjualan dan tb_detailpenjualan)
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Penjualan (Detail)</h1>
    <a href="?page=tambah_penjualan_detail" class="btn btn-primary">+ Transaksi Baru</a>
    <hr>
    <table class="table table-bordered">
        <tr><th>No</th><th>ID Penjualan</th><th>Tanggal</th><th>Pelanggan</th><th>Total</th><th>Aksi</th></tr>
        <?php
        $q = mysqli_query($koneksi, "SELECT p.*, pl.nama_pelanggan FROM tb_penjualan p LEFT JOIN tb_pelanggan pl ON p.id_pelanggan=pl.id_pelanggan ORDER BY id_penjualan DESC");
        $no=1;
        while($d = mysqli_fetch_assoc($q)){
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['id_penjualan']; ?></td>
                <td><?php echo $d['tanggal_penjualan']; ?></td>
                <td><?php echo htmlspecialchars($d['nama_pelanggan']); ?></td>
                <td><?php echo number_format($d['total_harga']); ?></td>
                <td>
                    <a href="?page=detail_penjualan&id=<?php echo $d['id_penjualan']; ?>" class="btn btn-info">Lihat</a>
                    <a href="?page=hapus_penjualan&id=<?php echo $d['id_penjualan']; ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
