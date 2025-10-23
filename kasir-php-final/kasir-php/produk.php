<?php
// halaman tampil produk
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Produk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Produk</li>
    </ol>
    <a href="?page=tambah_produk" class="btn btn-primary">+ Tambah Produk</a>
    <hr>
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php
        $q = mysqli_query($koneksi, "SELECT * FROM tb_produk ORDER BY id_produk DESC");
        $no=1;
        while($d = mysqli_fetch_assoc($q)){
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo htmlspecialchars($d['nama_produk']); ?></td>
                <td><?php echo number_format($d['harga_produk']); ?></td>
                <td><?php echo htmlspecialchars($d['stok_produk']); ?></td>
                <td>
                    <a href="?page=ubah_produk&id=<?php echo $d['id_produk']; ?>" class="btn btn-warning">Ubah</a>
                    <a href="?page=hapus_produk&id=<?php echo $d['id_produk']; ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php
            $no++;
        }
        ?>
    </table>
</div>
