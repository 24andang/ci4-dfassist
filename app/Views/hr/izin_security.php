<?= $this->extend('\layouts\layout\main') ?>

<?= $this->section('content') ?>
<?= $this->include('\layouts\layout\navbar') ?>

<div class="border rounded mt-3 p-3 row">
    <div class="col-6">
        <h3>Form Izin Security</h3>
        <h5><?= $user['nama']; ?></h5>
    </div>
    <div class="col-6">
        <?php if (session()->getFlashdata('message')) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<form action="/hr/izin/create" method="post">
    <!-- hidden -->
    <input type="text" value="<?= $user['id']; ?>" name="id" hidden>
    <input type="text" value="<?= $user['nama']; ?>" name="nama" hidden>
    <input type="text" value="<?= $user['departemen']; ?>" name="departemen" hidden>
    <input type="text" value="<?= $user['level']; ?>" name="level" hidden>
    <input type="text" value="<?= $user['nik']; ?>" name="nik" hidden>

    <div class="row mt-3">
        <div class="form-group col-4">
            <label for="alasan-izin">Pilih Izin</label>
            <select class="form-control" name="alasan_izin" id="alasan-izin">
                <option id="alasan-opt">--Pilih Izin--</option>
                <option value="datang terlambat">Datang Terlambat</option>
                <option value="pulang lebih awal">Pulang Lebih Awal</option>
                <option value="meninggalkan kantor">Meninggalkan Kantor</option>
                <option value="sakit">Sakit</option>
                <option value="luar kota">Luar Kota</option>
                <option value="tidak hadir">Tidak Hadir</option>
                <option value="izin lain-lain">Lain-lain</option>
            </select>
        </div>
        <div class="form-group col-4" id="alasan-tidak-hadir-div" style="display: none;">
            <label for="alasan-tidak-hadir">Alasan</label>
            <select class="form-control" name="alasan_tidak_hadir" id="alasan-tidak-hadir">
                <option id="tidak-hadir-opt">--Pilih Alasan Tidak Hadir--</option>
                <option value="Pernikahan Anak Karyawan">Pernikahan Anak Karyawan (2hari)</option>
                <option value="Kematian Suami/Istri Ortu/Mertua Karyawan">Kematian Suami/Istri Ortu/Mertua Karyawan (2hari)</option>
                <option value="Khitan/Pembabtisan Anak Karyawan">Khitan/Pembabtisan Anak Karyawan (2hari)</option>
                <option value="Istri Gugur Kandungan">Istri Gugur Kandungan (3hari)</option>
                <option value="Pernikahan Karyawan">Pernikahan Karyawan (3hari)</option>
                <option value="Kelahiran Anak Karyawan">Kelahiran Anak Karyawan (3hari)</option>
                <option value="Kakek/Nenek Meninggal">Kakek atau Nenek Meninggal (1hari)</option>
                <option value="Kematian Saudara Kandung Karyawan">Kematian Saudara Kandung dan atau Orang Serumah Karyawan (1hari)</option>
                <option value="Gugur Kandungan">Gugur Kandungan (sesuai surat dokter)</option>
            </select>
        </div>
        <div class="form-group col-3" id="waktu-awal-div" style="display: none;">
            <label for="waktu-awal">Jam</label>
            <input class="form-control" type="time" name="keterangan_waktu" id="waktu-awal" disabled>
        </div>
        <div class="form-group col-3" id="waktu-akhir-div" style="display: none;">
            <label for="waktu-akhir">Sampai Jam</label>
            <input class="form-control" type="time" name="sampai_dengan" id="waktu-akhir" disabled>
        </div>
        <div class="form-group bg-danger text-white rounded mt-3 col-4" style="display: none;" id="surat-dokter">
            <div class="p-3 bg-danger text-white rounded">*Kumpulkan surat keterangan dokter ke HR.</div>
        </div>
    </div>
    <div class="row border-top muted">
        <div class="form-group col-4" id="izin-awal-div" style="display: none;">
            <label for="izin-awal">Tanggal</label>
            <input class="form-control" type="date" name="izin_awal" id="izin-awal" required disabled>
            <span class="bg-danger text-white" id="span-tanggal-awal" style="display: none;"><small class="ml-3">*Tidak bisa memilih hari libur anda.</small></span>
        </div>
        <div class="form-group bg-secondary text-white rounded mt-3 col-4" id="centang-div" style="display: none;">
            <input class="form-check-input ml-1 mt-3" type="checkbox" name="centang" id="centang" disabled>
            <label class="ml-4" style="margin-top: 3%;" for="centang">Centang jika lebih dari 1 hari.</label>
        </div>
        <div class="form-group col-4" id="izin-akhir-div" style="display: none;">
            <label for="izin-akhir">Sampai Tanggal</label>
            <input class="form-control" type="date" name="izin_akhir" id="izin-akhir" disabled>
            <span class="bg-danger text-white" id="span-tanggal-akhir" style="display: none;"><small class="ml-3"></small></span>
        </div>
    </div>
    <div class="row border-top muted" id="keterangan-div" style="display: none;">
        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
        </div>
    </div>
    <div class="row border-top muted" id="transportasi-div" style="display: none;">
        <div class="form-group col-4">
            <label for="kendaraan">Kendaraan</label>
            <input class="form-control" type="text" name="kendaraan" id="kendaraan">
        </div>
        <div class="form-group col-4">
            <label for="pengemudi">Pengemudi</label>
            <input class="form-control" type="text" name="pengemudi" id="pengemudi">
        </div>
    </div>
    <div class="border-top muted" id="btn-div" style="display: none;">
        <button class="btn btn-primary mt-3" type="submit">Ajukan Izin</button>
    </div>

</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // db from controller
        const user = <?= json_encode($user) ?>;
        const jadwalDB = <?= json_encode($jadwal) ?>;
        const liburArr = jadwalDB.filter(function(item) {
            if (user.nama == item.nama_1 || user.nama == item.nama_2) {
                return item;
            }
        });
        const tglLiburArr = liburArr.map((item) => item.tanggal);

        // view only
        const alasanIzin = document.getElementById('alasan-izin');
        const alasanOpt = document.getElementById('alasan-opt');
        const waktuAwalDiv = document.getElementById('waktu-awal-div');
        const waktuAwal = document.getElementById('waktu-awal');
        const waktuAkhirDiv = document.getElementById('waktu-akhir-div');
        const waktuAkhir = document.getElementById('waktu-akhir');
        const suratDokter = document.getElementById('surat-dokter');
        const tanggalAwalDiv = document.getElementById('izin-awal-div');
        const tanggalAkhirDiv = document.getElementById('izin-akhir-div');
        const tanggalAwal = document.getElementById('izin-awal');
        const tanggalAkhir = document.getElementById('izin-akhir');
        const centangDiv = document.getElementById('centang-div');
        const centang = document.getElementById('centang');
        const tidakHadirDiv = document.getElementById('alasan-tidak-hadir-div');
        const tidakHadir = document.getElementById('alasan-tidak-hadir');
        const tidakHadirOpt = document.getElementById('tidak-hadir-opt');
        const spanTglAwal = document.getElementById('span-tanggal-awal');
        const spanTglAkhir = document.getElementById('span-tanggal-akhir');
        const keteranganDiv = document.getElementById('keterangan-div');
        const keterangan = document.getElementById('keterangan');
        const transDiv = document.getElementById('transportasi-div');
        const btnDiv = document.getElementById('btn-div');

        alasanIzin.addEventListener('change', function() {
            alasanOpt.style.display = 'none';
            tanggalAwalDiv.style.display = 'block';
            tanggalAwal.disabled = false;
            centang.checked = false;
            tanggalAkhirDiv.style.display = 'none';
            tanggalAkhir.value = '';
            keteranganDiv.style.display = 'none';
            btnDiv.style.display = 'none';

            if (alasanIzin.value == 'datang terlambat' || alasanIzin.value == 'pulang lebih awal') {
                waktuAwalDiv.style.display = 'block';
                waktuAwal.value = '';
                waktuAwal.disabled = false;
                waktuAwal.required = true;
                keterangan.required = true;
                tanggalAwalDiv.style.display = 'none';
                // stop
                waktuAkhirDiv.style.display = 'none';
                waktuAkhir.value = false;
                waktuAkhir.disabled = true;
                tanggalAkhirDiv.style.display = 'none';
                tanggalAkhir.value = '';
                tanggalAkhir.disabled = true;
                centangDiv.style.display = 'none';
                suratDokter.style.display = 'none';
                tidakHadirDiv.style.display = 'none';
                tidakHadir.disabled = true;
                transDiv.style.display = 'none';
            } else if (alasanIzin.value == 'meninggalkan kantor') {
                waktuAwalDiv.style.display = 'block';
                waktuAwal.disabled = false;
                waktuAwal.value = '';
                waktuAkhirDiv.style.display = 'none';
                waktuAkhir.disabled = false;
                waktuAwal.required = true;
                waktuAkhir.required = true;
                keterangan.required = true;
                waktuAkhir.value = '';
                tanggalAwalDiv.style.display = 'none';
                // stop
                tanggalAkhirDiv.style.display = 'none';
                tanggalAkhir.value = '';
                tanggalAkhir.disabled = true;
                centangDiv.style.display = 'none';
                suratDokter.style.display = 'none';
                tidakHadirDiv.style.display = 'none';
                tidakHadir.disabled = true;
            } else if (alasanIzin.value == 'sakit') {
                suratDokter.style.display = 'block';
                centangDiv.style.display = 'block';
                keterangan.required = true;
                // stop
                waktuAwalDiv.style.display = 'none';
                waktuAwal.disabled = true;
                waktuAwal.value = '';
                waktuAkhirDiv.style.display = 'none';
                waktuAkhir.disabled = true;
                waktuAkhir.value = '';
                tidakHadirDiv.style.display = 'none';
                tidakHadir.disabled = true;
                transDiv.style.display = 'none';
            } else if (alasanIzin.value === 'luar kota' || alasanIzin.value === 'izin lain-lain') {
                centangDiv.style.display = 'block';
                keterangan.required = true;
                transDiv.style.display = 'flex';
                //stop
                waktuAwalDiv.style.display = 'none';
                waktuAwal.disabled = true;
                waktuAwal.value = '';
                waktuAkhirDiv.style.display = 'none';
                waktuAkhir.disabled = true;
                waktuAkhir.value = '';
                suratDokter.style.display = 'none';
                tidakHadirDiv.style.display = 'none';
                tidakHadir.disabled = true;
            } else if (alasanIzin.value === 'tidak hadir') {
                tidakHadirDiv.style.display = 'block';
                tidakHadir.disabled = false;
                tanggalAkhirDiv.style.display = 'block';
                tanggalAkhir.disabled = false;
                tanggalAkhir.readOnly = true;
                //stop
                keterangan.required = false;
                centangDiv.style.display = 'none';
                waktuAwalDiv.style.display = 'none';
                waktuAwal.disabled = true;
                waktuAwal.value = '';
                waktuAkhirDiv.style.display = 'none';
                waktuAkhir.disabled = true;
                waktuAkhir.value = '';
                suratDokter.style.display = 'none';
                transDiv.style.display = 'none';
            } else {
                keterangan.required = true;
                waktuAwalDiv.style.display = 'none';
                waktuAwal.disabled = true;
                waktuAwal.value = '';
                waktuAwal.required = false;
                waktuAkhirDiv.style.display = 'none';
                waktuAkhir.disabled = true;
                waktuAkhir.value = '';
                waktuAkhir.required = false;
                suratDokter.style.display = 'none';
                centangDiv.style.display = 'none';
                tidakHadirDiv.style.display = 'none';
                tidakHadir.disabled = true;
                transDiv.style.display = 'none';
            }
        });

        tidakHadir.addEventListener('change', function() {
            tidakHadirOpt.style.display = 'none';
            tanggalAwal.value = '';
            tanggalAkhir.value = '';

            if (tidakHadir.value == 'Gugur Kandungan') {
                tanggalAkhir.readOnly = false;
                suratDokter.style.display = 'block';
            } else {
                tanggalAkhir.readOnly = true;
            }

            tanggalAwal.addEventListener('change', function() {
                let tglAwal = new Date(tanggalAwal.value);
                tglAwal.getTime();
                let hakIzin = 1;

                if (tidakHadir.value == 'Kakek/Nenek Meninggal' ||
                    tidakHadir.value == 'Kematian Saudara Kandung Karyawan'
                ) {
                    tglAwal.setDate(tglAwal.getDate());
                    tanggalAkhir.value = tglAwal.toISOString().split('T')[0];
                } else if (tidakHadir.value == 'Pernikahan Anak Karyawan' ||
                    tidakHadir.value == 'Kematian Suami/Istri Ortu/Mertua Karyawan' ||
                    tidakHadir.value == 'Khitan/Pembabtisan Anak Karyawan'
                ) {
                    tglAwal.setDate(tglAwal.getDate() + hakIzin);
                    tanggalAkhir.value = tglAwal.toISOString().split('T')[0];

                    while (tglLiburArr.includes(tanggalAkhir.value)) {
                        tglAwal.setDate(tglAwal.getDate() + hakIzin + 1);
                        tanggalAkhir.value = tglAwal.toISOString().split('T')[0];
                    }
                } else if (tidakHadir.value == 'Istri Gugur Kandungan' ||
                    tidakHadir.value == 'Pernikahan Karyawan' ||
                    tidakHadir.value == 'Kelahiran Anak Karyawan'
                ) {
                    tglAwal.setDate(tglAwal.getDate() + hakIzin + 1);
                    tanggalAkhir.value = tglAwal.toISOString().split('T')[0];

                    while (tglLiburArr.includes(tanggalAkhir.value)) {
                        tglAwal.setDate(tglAwal.getDate() + hakIzin + 2);
                        tanggalAkhir.value = tglAwal.toISOString().split('T')[0];
                    }
                }
            });
        });

        waktuAwal.addEventListener('change', function() {
            waktuAwalDiv.style.display = 'block';
            tanggalAwalDiv.style.display = 'block';
            if (alasanIzin.value == 'meninggalkan kantor') {
                waktuAkhirDiv.style.display = 'block';
                tanggalAwalDiv.style.display = 'none';
                waktuAkhir.addEventListener('change', function() {
                    tanggalAwalDiv.style.display = 'block';
                    tanggalAwal.addEventListener('change', function() {
                        transDiv.style.display = 'flex';
                    });
                });
            } else {
                waktuAkhirDiv.style.display = 'none';
                transDiv.style.display = 'none';
            }
        });

        tanggalAwal.addEventListener('change', function() {
            if (tglLiburArr.includes(tanggalAwal.value)) {
                spanTglAwal.style.display = 'block';
                tanggalAwal.value = '';
                tanggalAkhirDiv.style.display = 'none';
                tanggalAkhir.value = '';
                centang.checked = false;
                centang.disabled = true;
            } else {
                spanTglAwal.style.display = 'none';
                tanggalAkhir.style.display = 'block';
                tanggalAkhir.disabled = false;
                centang.disabled = false;
            }

            if (!tanggalAwal.value) {
                keteranganDiv.style.display = 'none';
                btnDiv.style.display = 'none';
                centang.checked = false;
                centang.disabled = true;
                tanggalAkhirDiv.style.display = 'none';
                tanggalAkhir.value = '';
            } else {
                keteranganDiv.style.display = 'block';
                btnDiv.style.display = 'block';
            }
        });

        tanggalAkhir.addEventListener('change', function() {
            let tglAwal = new Date(tanggalAwal.value);
            let tglAkhir = new Date(tanggalAkhir.value);
            if (tglAwal.getTime() > tglAkhir.getTime()) {
                tanggalAkhir.value = '';
                spanTglAkhir.style.display = 'block';
                spanTglAkhir.querySelector('small').textContent = '*Tanggal tidak bisa mundur.';
            } else if (tglLiburArr.includes(tanggalAkhir.value)) {
                tanggalAkhir.value = '';
                spanTglAkhir.style.display = 'block';
                spanTglAkhir.querySelector('small').textContent = '*Tidak bisa memilih hari libur anda.';
            } else {
                spanTglAkhir.style.display = 'none';
            }
        });

        centang.addEventListener('change', function() {
            if (centang.checked) {
                tanggalAkhirDiv.style.display = 'block';
                tanggalAkhir.disabled = false;
            } else {
                tanggalAkhirDiv.style.display = 'none';
                tanggalAkhir.value = '';
                tanggalAkhir.disabled = true;
            }
        });
    });
</script>

<?= $this->endSection() ?>