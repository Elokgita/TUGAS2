<?php
if (isset($_POST['nama_pelanggan'])) {
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
    $alamat  = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $no_telepon = mysqli_real_escape_string($koneksi, $_POST['no_telepon']);

    $query = mysqli_query($koneksi, "INSERT INTO tb_pelanggan(nama_pelanggan, alamat_pelanggan, no_telp_pelanggan) VALUES('$nama', '$alamat', '$no_telepon')");

    if ($query) {
        echo "<script>alert('Data berhasil disimpan');location.href='?page=pelanggan'</script>";
    } else {
        echo "<script>alert('Data gagal disimpan: ".mysqli_error($koneksi)."')</script>";
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Pelanggan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Tambah Pelanggan</li>
    </ol>

    <form method="post" action="">
        <table class="table">
            <tr>
                <td>Nama Pelanggan</td>
                <td>:</td>
                <td><input class="form-control" type="text" name="nama_pelanggan" required></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><textarea class="form-control" name="alamat" required></textarea></td>
            </tr>
            <tr>
                <td>No Telepon</td>
                <td>:</td>
                <td><input class="form-control" type="text" name="no_telepon" required></td>
            </tr>
            <tr>
                <td></td><td></td>
                <td>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="?page=pelanggan" class="btn btn-secondary">Batal</a>
                </td>
            </tr>
        </table>
    </form>
</div>
