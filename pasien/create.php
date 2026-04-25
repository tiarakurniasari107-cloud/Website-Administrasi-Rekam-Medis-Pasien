<?php
require_once '../config/auth.php';

$nextNoRm = 'RM-000001';
$resultNoRm = mysqli_query($koneksi, "SELECT MAX(CAST(SUBSTRING(no_rm, 4) AS UNSIGNED)) AS max_no FROM pasien WHERE no_rm LIKE 'RM-%'");
if ($resultNoRm instanceof mysqli_result) {
    $rowNoRm = mysqli_fetch_assoc($resultNoRm);
    $nextNumber = (int) ($rowNoRm['max_no'] ?? 0) + 1;
    $nextNoRm = 'RM-' . str_pad((string) $nextNumber, 6, '0', STR_PAD_LEFT);
    mysqli_free_result($resultNoRm);
}
?>

<?php
$pageTitle = 'Tambah Pasien';
require_once '../includes/header.php';
?>

<div class="container">
    <section class="page-header">
        <h2>Tambah Pasien</h2>
        <p>Formulir pendaftaran pasien baru</p>
    </section>

    <section class="content-card form-card">
        <div class="toolbar-row">
            <div class="toolbar-actions">
                <a href="index.php" class="btn btn-back"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>Kembali</a>
            </div>
        </div>

        <form action="proses.php" method="POST" autocomplete="off">
            <input type="hidden" name="no_rm" value="<?= htmlspecialchars($nextNoRm, ENT_QUOTES, 'UTF-8'); ?>">

            <div class="form-grid">
                <div class="mb-2 field-full">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" name="nik" class="form-control" placeholder="Masukkan NIK (16 digit)">
                </div>

                <div class="mb-2 field-full">
                    <label for="nama_pasien">Nama Pasien</label>
                    <input type="text" id="nama_pasien" name="nama_pasien" class="form-control" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="mb-2">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" placeholder="Kota/kabupaten lahir">
                </div>

                <div class="mb-2">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control">
                </div>

                <div class="mb-2">
                    <label for="umur">Umur</label>
                    <input type="number" id="umur" name="umur" class="form-control" placeholder="Tahun">
                </div>

                <div class="mb-2 field-full">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-control" placeholder="Alamat lengkap pasien"></textarea>
                </div>

                <div class="mb-2 field-full">
                    <label for="no_telp">No Telepon</label>
                    <input type="text" id="no_telp" name="no_telp" class="form-control" placeholder="08xxxxxxxxxx">
                </div>

                <div class="mb-2">
                    <label for="golongan_darah">Golongan Darah</label>
                    <select id="golongan_darah" name="golongan_darah" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="status_kawin">Status Kawin</label>
                    <input type="text" id="status_kawin" name="status_kawin" class="form-control" placeholder="Status pernikahan">
                </div>

                <div class="mb-2 field-full">
                    <label for="alergi">Alergi</label>
                    <textarea id="alergi" name="alergi" class="form-control" placeholder="Tuliskan alergi pasien"></textarea>
                </div>

                <div class="mb-2 field-full">
                    <label for="pekerjaan">Pekerjaan</label>
                    <input type="text" id="pekerjaan" name="pekerjaan" class="form-control" placeholder="Pekerjaan pasien">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>
