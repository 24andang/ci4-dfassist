<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Surat Cuti</title>
    <!-- Tambahkan Bootstrap atau CSS lainnya jika diperlukan -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function updateSisaCuti() {
            var periode = document.getElementById("periode").value;
            var sisaCutiField = document.getElementById("sisa_cuti");
            var sisaCutiData = <?= json_encode($sisa_cuti_data); ?>;

            sisaCutiField.value = sisaCutiData[periode] || 0;
        }
    </script>
</head>

<body>
    <div class="container mt-5">
        <h2>Form Surat Cuti</h2>
        <form action="<?= base_url('surat-cuti/submit'); ?>" method="post">
            <?= csrf_field(); ?>
            <div class="form-group">
                <label for="nik">NIK:</label>
                <input type="text" class="form-control" id="nik" name="nik" value="<?= session()->get('nik'); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="periode">Periode:</label>
                <select id="periode" name="periode" class="form-control" onchange="updateSisaCuti()" required>
                    <option value="">Pilih Periode</option>
                    <?php foreach ($periode_options as $periode): ?>
                        <option value="<?= $periode; ?>"><?= $periode; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="sisa_cuti">Sisa Cuti:</label>
                <input type="number" class="form-control" id="sisa_cuti" name="sisa_cuti" readonly>
            </div>
            <div class="form-group">
                <label for="alasan_izin">Alasan Izin:</label>
                <select id="alasan_izin" name="alasan_izin" class="form-control" required>
                    <option value="">Pilih Alasan</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="pulang_awal">Pulang Awal</option>
                    <option value="datang_terlambat">Datang Terlambat</option>
                    <option value="cuti_lain_lain">Cuti Lain-lain</option>
                    <option value="dinas_luar_kota">Dinas Luar Kota</option>
                </select>
            </div>
            <div class="form-group">
                <label for="departemen">Departemen:</label>
                <input type="text" class="form-control" id="departemen" name="departemen" required>
            </div>
            <div class="form-group">
                <label for="izin_awal">Tanggal Awal Cuti:</label>
                <input type="date" class="form-control" id="izin_awal" name="izin_awal" required>
            </div>
            <div class="form-group">
                <label for="izin_akhir">Tanggal Akhir Cuti:</label>
                <input type="date" class="form-control" id="izin_akhir" name="izin_akhir" required>
            </div>
            <div class="form-group">
                <label for="izin_awal2">Tanggal Awal Cuti 2:</label>
                <input type="date" class="form-control" id="izin_awal2" name="izin_awal2">
            </div>
            <div class="form-group">
                <label for="izin_akhir2">Tanggal Akhir Cuti 2:</label>
                <input type="date" class="form-control" id="izin_akhir2" name="izin_akhir2">
            </div>
            <!-- Label untuk total cuti -->
            <div class="form-group">
                <label for="total_cuti">Total Cuti</label>
                <input type="text" class="form-control" id="total_cuti" name="total_cuti" readonly value="<?= isset($total_cuti) ? $total_cuti : 0 ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function calculateTotalCuti() {
                const izinAwal1 = new Date(document.getElementById('izin_awal').value);
                const izinAkhir1 = new Date(document.getElementById('izin_akhir').value);
                const izinAwal2 = new Date(document.getElementById('izin_awal2').value);
                const izinAkhir2 = new Date(document.getElementById('izin_akhir2').value);

                let totalHari = 0;

                // Hitung total hari untuk periode pertama
                if (izinAwal1 && !isNaN(izinAwal1.getTime())) {
                    if (izinAkhir1 && !isNaN(izinAkhir1.getTime())) {
                        totalHari += (izinAkhir1 - izinAwal1) / (1000 * 60 * 60 * 24) + 1; // +1 untuk inklusif hari terakhir
                    } else {
                        totalHari = 1; // Hanya tanggal awal yang diisi
                    }
                }

                // Hitung total hari untuk periode kedua
                if (izinAwal2 && !isNaN(izinAwal2.getTime())) {
                    if (izinAkhir2 && !isNaN(izinAkhir2.getTime())) {
                        totalHari += (izinAkhir2 - izinAwal2) / (1000 * 60 * 60 * 24) + 1; // +1 untuk inklusif hari terakhir
                    } else {
                        if (totalHari === 0) { // Jika belum ada total hari yang dihitung
                            totalHari = 1; // Hanya tanggal awal kedua yang diisi
                        }
                    }
                }

                document.getElementById('total_cuti').value = Math.floor(totalHari);
            }

            // Tambahkan event listener untuk setiap input tanggal
            document.getElementById('izin_awal').addEventListener('change', calculateTotalCuti);
            document.getElementById('izin_akhir').addEventListener('change', calculateTotalCuti);
            document.getElementById('izin_awal2').addEventListener('change', calculateTotalCuti);
            document.getElementById('izin_akhir2').addEventListener('change', calculateTotalCuti);
        });
    </script>
</body>

</html>