<?php
$id = isset($_GET['id'])?intval($_GET['id']):0;
if (!$id) { echo "<script>alert('ID tidak valid');location.href='?page=penjualan'</script>"; exit; }
// also delete details if exist
mysqli_query($koneksi, "DELETE FROM tb_detailpenjualan WHERE id_penjualan=$id");
$q = mysqli_query($koneksi, "DELETE FROM tb_penjualan WHERE id_penjualan=$id");
if ($q) { echo "<script>alert('Penjualan dihapus');location.href='?page=penjualan'</script>"; }
else { echo "<script>alert('Gagal: ".mysqli_error($koneksi)."');location.href='?page=penjualan'</script>"; }
