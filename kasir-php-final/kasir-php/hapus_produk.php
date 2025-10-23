<?php
$id = isset($_GET['id'])?intval($_GET['id']):0;
if (!$id) { echo "<script>alert('ID tidak valid');location.href='?page=produk'</script>"; exit; }
$q = mysqli_query($koneksi, "DELETE FROM tb_produk WHERE id_produk=$id");
if ($q) { echo "<script>alert('Produk berhasil dihapus');location.href='?page=produk'</script>"; }
else { echo "<script>alert('Gagal: ".mysqli_error($koneksi)."');location.href='?page=produk'</script>"; }
