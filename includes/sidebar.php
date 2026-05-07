<div class="sidebar">
    <h4 class="p-3">Klinik</h4>
    <a href="../dashboard/index.php">Dashboard</a>
    <?php if (clinic_can_access_module('pasien', 'read')) { ?><a href="../pasien/index.php">Pasien</a><?php } ?>
    <?php if (clinic_can_access_module('kunjungan', 'read')) { ?><a href="../kunjungan/index.php">Registrasi</a><?php } ?>
    <?php if (clinic_can_access_module('pemeriksaan', 'read')) { ?><a href="../pemeriksaan/index.php">Pemeriksaan</a><?php } ?>
    <?php if (clinic_can_access_module('rekam_medis', 'read')) { ?><a href="../rekam_medis/index.php">Rekam Medis</a><?php } ?>
    <?php if (clinic_can_access_module('dokter', 'read')) { ?><a href="../dokter/index.php">Dokter</a><?php } ?>
    <?php if (clinic_can_access_module('poli', 'read')) { ?><a href="../poli/index.php">Poli</a><?php } ?>
    <?php if (clinic_can_access_module('laporan', 'read')) { ?><a href="../laporan/index.php">Laporan</a><?php } ?>
    <a href="../auth/logout.php">Logout</a>
</div>
