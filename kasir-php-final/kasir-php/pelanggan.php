<?php
// tampilkan halaman pelanggan
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Pelanggan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Pelanggan</li>
    </ol>
    <a href="?page=tambah_pelanggan" class="btn btn-primary">+ Tambah Data</a>
    <hr>
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Alamat</th>
            <th>No Telepon</th>
            <th>Aksi</th>
        </tr>
        <?php
        // ambil data pelanggan dari database
        $query = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan ORDER BY id_pelanggan DESC");
        $no = 1;
        while($data = mysqli_fetch_assoc($query)){
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo htmlspecialchars($data['nama_pelanggan']); ?></td>
                <td><?php echo htmlspecialchars($data['alamat_pelanggan']); ?></td>
                <td><?php echo htmlspecialchars($data['no_telp_pelanggan']); ?></td>
                <td>
                    <a href="?page=ubah_pelanggan&amp;id=<?php echo $data['id_pelanggan']; ?>" class="btn btn-warning">Ubah</a>
                    <a href="?page=hapus_pelanggan&amp;id=<?php echo $data['id_pelanggan']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php
            $no++;
        }
        ?>
    </table>
</div>
