<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) {
    echo "<script>alert('ID tidak valid');location.href='?page=pelanggan'</script>";
    exit;
}

if (isset($_POST['nama_pelanggan'])) {
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
    $alamat  = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $no_telepon = mysqli_real_escape_string($koneksi, $_POST['no_telepon']);

    $query = mysqli_query($koneksi, "UPDATE tb_pelanggan SET nama_pelanggan='$nama', alamat_pelanggan='$alamat', no_telp_pelanggan='$no_telepon' WHERE id_pelanggan=$id");

    if ($query) {
        echo "<script>alert('Data berhasil diubah');location.href='?page=pelanggan'</script>";
    } else {
        echo "<script>alert('Data gagal diubah: ".mysqli_error($koneksi)."')</script>";
    }
}

// ambil data lama
$q = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan WHERE id_pelanggan=$id");
if (mysqli_num_rows($q) == 0) {
    echo "<script>alert('Data tidak ditemukan');location.href='?page=pelanggan'</script>";
    exit;
}
$data = mysqli_fetch_assoc($q);
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Ubah Pelanggan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Ubah Pelanggan</li>
    </ol>

    <form method="post" action="">
        <table class="table">
            <tr>
                <td>Nama Pelanggan</td>
                <td>:</td>
                <td><input class="form-control" type="text" name="nama_pelanggan" value="<?php echo htmlspecialchars($data['nama_pelanggan']); ?>" required></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><textarea class="form-control" name="alamat" required><?php echo htmlspecialchars($data['alamat_pelanggan']); ?></textarea></td>
            </tr>
            <tr>
                <td>No Telepon</td>
                <td>:</td>
                <td><input class="form-control" type="text" name="no_telepon" value="<?php echo htmlspecialchars($data['no_telp_pelanggan']); ?>" required></td>
            </tr>
            <tr>
                <td></td><td></td>
                <td>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="?page=pelanggan" class="btn btn-secondary">Batal</a>
                </td>
            </tr>
        </table>
    </form>
</div>
