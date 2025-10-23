<?php
// proses membuat transaksi dan detailnya (satu form menambahkan item bertahap)
if (!isset($_SESSION)) session_start();

// create new transaction
if (isset($_POST['create_transaction'])) {
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal_penjualan']);
    $id_pelanggan = intval($_POST['id_pelanggan']);
    $q = mysqli_query($koneksi, "INSERT INTO tb_penjualan(tanggal_penjualan, total_harga, id_pelanggan) VALUES('$tanggal', 0, $id_pelanggan)");
    if ($q) {
        $last_id = mysqli_insert_id($koneksi);
        // store in session current transaction id
        $_SESSION['current_tx'] = $last_id;
        echo "<script>location.href='?page=tambah_penjualan_detail'</script>";
        exit;
    } else {
        echo "<script>alert('Gagal membuat transaksi: ".mysqli_error($koneksi)."')</script>";
    }
}

// add item to current transaction
if (isset($_POST['add_item']) && isset($_SESSION['current_tx'])) {
    $tx = intval($_SESSION['current_tx']);
    $id_produk = intval($_POST['id_produk']);
    $jumlah = intval($_POST['jumlah_produk']);
    // ambil harga produk
    $r = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE id_produk=$id_produk");
    $prod = mysqli_fetch_assoc($r);
    $sub = $prod['harga_produk'] * $jumlah;
    mysqli_query($koneksi, "INSERT INTO tb_detailpenjualan(id_penjualan, id_produk, jumlah_produk, sub_total) VALUES($tx, $id_produk, $jumlah, $sub)");
    // update total in tb_penjualan
    $res = mysqli_query($koneksi, "SELECT SUM(sub_total) as tot FROM tb_detailpenjualan WHERE id_penjualan=$tx");
    $sum = mysqli_fetch_assoc($res);
    mysqli_query($koneksi, "UPDATE tb_penjualan SET total_harga=".intval($sum['tot'])." WHERE id_penjualan=$tx");
    echo "<script>location.href='?page=tambah_penjualan_detail'</script>";
    exit;
}

// finish transaction
if (isset($_POST['finish_tx']) && isset($_SESSION['current_tx'])) {
    unset($_SESSION['current_tx']);
    echo "<script>alert('Transaksi selesai');location.href='?page=penjualan_detail'</script>";
    exit;
}

// cancel transaction: delete penjualan and its details
if (isset($_GET['cancel']) && isset($_SESSION['current_tx'])) {
    $tx = intval($_SESSION['current_tx']);
    mysqli_query($koneksi, "DELETE FROM tb_detailpenjualan WHERE id_penjualan=$tx");
    mysqli_query($koneksi, "DELETE FROM tb_penjualan WHERE id_penjualan=$tx");
    unset($_SESSION['current_tx']);
    echo "<script>location.href='?page=penjualan_detail'</script>";
    exit;
}

$pel = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan ORDER BY nama_pelanggan");
$pro = mysqli_query($koneksi, "SELECT * FROM tb_produk ORDER BY nama_produk");
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Transaksi Penjualan (Detail)</h1>
    <?php if (!isset($_SESSION['current_tx'])) { ?>
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
                <tr><td></td><td></td><td><button class="btn btn-primary" name="create_transaction" type="submit">Buat Transaksi</button> <a class="btn btn-secondary" href="?page=penjualan_detail">Batal</a></td></tr>
            </table>
        </form>
    <?php } else {
        $tx = intval($_SESSION['current_tx']);
        echo '<p>Transaksi berjalan: ID = '.htmlspecialchars($tx).' <a class="btn btn-danger" href="?page=tambah_penjualan_detail&cancel=1" onclick="return confirm(\'Batal transaksi?\')">Batal Transaksi</a></p>';
        // show items
        $items = mysqli_query($koneksi, "SELECT d.*, pr.nama_produk, pr.harga_produk FROM tb_detailpenjualan d JOIN tb_produk pr ON d.id_produk=pr.id_produk WHERE d.id_penjualan=$tx");
        ?>
        <form method="post" action="">
            <table class="table">
                <tr><td>Produk</td><td>:</td><td>
                    <select name="id_produk" class="form-control" required>
                        <option value="">-- Pilih Produk --</option>
                        <?php while($p=mysqli_fetch_assoc($pro)){ ?>
                            <option value="<?php echo $p['id_produk']; ?>"><?php echo htmlspecialchars($p['nama_produk']).' ('.number_format($p['harga_produk']).')'; ?></option>
                        <?php } ?>
                    </select>
                </td></tr>
                <tr><td>Jumlah</td><td>:</td><td><input type="number" name="jumlah_produk" class="form-control" required min="1" value="1"></td></tr>
                <tr><td></td><td></td><td><button class="btn btn-primary" name="add_item" type="submit">Tambah Item</button></td></tr>
            </table>
        </form>
        <h4>Daftar Item</h4>
        <table class="table table-bordered">
            <tr><th>No</th><th>Produk</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th></tr>
            <?php
            $no=1; $total=0;
            while($it = mysqli_fetch_assoc($items)){
                echo '<tr>';
                echo '<td>'.($no++).'</td>';
                echo '<td>'.htmlspecialchars($it['nama_produk']).'</td>';
                echo '<td>'.number_format($it['harga_produk']).'</td>';
                echo '<td>'.htmlspecialchars($it['jumlah_produk']).'</td>';
                echo '<td>'.number_format($it['sub_total']).'</td>';
                echo '</tr>';
                $total += $it['sub_total'];
            }
            echo '<tr><td colspan="4"><strong>Total</strong></td><td>'.number_format($total).'</td></tr>';
            ?>
        </table>
        <form method="post" action="">
            <button class="btn btn-success" name="finish_tx" type="submit">Selesai Transaksi</button>
        </form>
    <?php } ?>
</div>
