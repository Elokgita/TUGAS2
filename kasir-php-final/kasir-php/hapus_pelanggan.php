<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) {
    echo "<script>alert('ID tidak valid');location.href='?page=pelanggan'</script>";
    exit;
}
$q = mysqli_query($koneksi, "DELETE FROM tb_pelanggan WHERE id_pelanggan=$id");
if ($q) {
    echo "<script>alert('Data berhasil dihapus');location.href='?page=pelanggan'</script>";
} else {
    echo "<script>alert('Data gagal dihapus: ".mysqli_error($koneksi)."');location.href='?page=pelanggan'</script>";
}
