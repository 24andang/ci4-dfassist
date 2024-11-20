<?= $this->extend('\layouts\layout\main') ?>

<?= $this->section('content') ?>
<?= $this->include('\layouts\layout\navbar') ?>

<!-- header -->
<form action="<?= base_url('/hr/cuti/submit'); ?>" method="post">
    <input type="text" name="alasan_izin" value="cuti" hidden>
    <input type="text" name="nik" value="<?= $user['nik']; ?>" hidden>
    <input type="text" name="inisial" value="<?= $user['inisial']; ?>" hidden>
    <input type="text" name="nama" value="<?= $user['nama']; ?>" hidden>
    <input type="text" name="level" value="<?= $user['level']; ?>" hidden>
    <input type="text" name="departemen" value="<?= $user['departemen']; ?>" hidden>
    <div class="border rounded mt-3 p-3 row">
        <div class="col-6">
            <h3>Form Cuti Security</h3>
            <h5><?= $user['nama']; ?></h5>
            <div class="row border-top muted mt-3">
                <div class="form-group col-4">
                    <label for="periode">Periode</label>
                    <select name="periode" id="periode" class="form-control">
                        <option id="periode-opt">--Pilih Periode--</option>
                        <?php foreach ($sisa_cuti as $cuti): ?>
                            <option value="<?= $cuti['periode']; ?>"><?= $cuti['periode']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-4">
                    <label for="sisa-cuti">Sisa Cuti</label>
                    <h3 id="sisa-cuti"></h3>
                    <input type="number" name="sisa_cuti" id="sisa-cuti-hidden" hidden>
                    <input type="number" name="sisa_cuti_hidden" id="sisa-cuti-hide" hidden>
                </div>
                <div class="form-group col-4">
                    <label for="lama-cuti">Lama Cuti</label>
                    <h3 id="lama-cuti"></h3>
                    <input type="number" name="total_cuti" id="lama-cuti-hidden" hidden>
                </div>
            </div>
        </div>
        <div class="col-6">
            <?php if (session()->getFlashdata('pass_cuti')) : ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('pass_cuti') ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-6" id="cegah-submit" style="display: none;">
            <div class="alert alert-warning">
                Lama cuti tidak boleh melebihi sisa cuti.
            </div>
        </div>
    </div>

    <!-- form -->
    <div class="row mt-3" style="display: none;" id="cuti-habis-div">
        <div class="alert alert-warning"></div>
    </div>
    <div class="row mt-3">
        <div class="form-group col-3" id="izin-awal-div" style="display: none;">
            <label for="izin-awal">Tanggal</label>
            <input class="form-control" type="date" name="izin_awal" id="izin-awal" required>
            <span class="bg-danger text-white" id="span-tanggal-awal" style="display: none;"><small class="ml-3">*Tidak bisa memilih hari libur anda.</small></span>
        </div>
        <div class="form-group bg-secondary text-white rounded mt-3 col-3" id="centang-div" style="display: none;">
            <input class="form-check-input ml-1 mt-3" type="checkbox" name="centang" id="centang" disabled>
            <label class="ml-4" style="margin-top: 3%;" for="centang">Centang jika lebih dari 1 hari.</label>
        </div>
        <div class="form-group col-3" id="izin-akhir-div" style="display: none;">
            <label for="izin-akhir">Sampai Tanggal</label>
            <input class="form-control" type="date" name="izin_akhir" id="izin-akhir">
            <span class="bg-danger text-white" id="span-tanggal-akhir" style="display: none;"><small class="ml-3"></small></span>
        </div>
    </div>
    <div class="row border-top muted" id="keterangan-div" style="display: none;">
        <div class="form-group col-6">
            <label for="keterangan">Keterangan</label>
            <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
        </div>
        <div class="col-6" id="tanggal-kembali-div">
            Tanggal Kembali Bekerja<br />
            <h3 id="tanggal-kembali"></h3>
            <input type="date" class="form-control" id="tgl-masuk-kerja" name="tgl_masuk_kerja" readonly hidden>
        </div>
    </div>
    <div class="row border-top-muted" id="kontak" style="display: none;">
        <div class="col-4">
            <label for="alamat">Alamat Selama Cuti :</label>
            <input type="text" class="form-control" id="alamat" name="alamat">
        </div>
        <div class="col-4">
            <label for="telp">No Telepon :</label>
            <input type="text" class="form-control" id="telp" name="telp">
        </div>
    </div>
    <div id="submit-div" style="display: none;">
        <button type="submit" class="btn btn-primary mt-3 mb-3" id="btn-submit">Ajukan Cuti</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // from db
        const cutiDB = <?= json_encode($sisa_cuti) ?>;
        const jadwalDB = <?= json_encode($jadwal) ?>;
        const tglLiburArr = jadwalDB.map((item) => item.tanggal);

        // by view
        const periode = document.getElementById('periode');
        const periodeOpt = document.getElementById('periode-opt');
        const sisaCuti = document.getElementById('sisa-cuti');
        const sisaCutiHidden = document.getElementById('sisa-cuti-hidden');
        const lamaCuti = document.getElementById('lama-cuti');
        const lamaCutiHidden = document.getElementById('lama-cuti-hidden');
        const cutiHabisDiv = document.getElementById('cuti-habis-div');
        const tanggalAwalDiv = document.getElementById('izin-awal-div');
        const tanggalAkhirDiv = document.getElementById('izin-akhir-div');
        const tanggalAwal = document.getElementById('izin-awal');
        const tanggalAkhir = document.getElementById('izin-akhir');
        const tanggalKembaliDiv = document.getElementById('tanggal-kembali-div');
        const tanggalKembali = document.getElementById('tanggal-kembali');
        const tglMasukKerja = document.getElementById('tgl-masuk-kerja');
        const spanTglAwal = document.getElementById('span-tanggal-awal');
        const spanTglAkhir = document.getElementById('span-tanggal-akhir');
        const centangDiv = document.getElementById('centang-div');
        const centang = document.getElementById('centang');
        const keteranganDiv = document.getElementById('keterangan-div');
        const keterangan = document.getElementById('keterangan');
        const kontakDiv = document.getElementById('kontak');
        const telp = document.getElementById('telp');
        const btnDiv = document.getElementById('submit-div');
        const btnSubmit = document.getElementById('btn-submit');
        const cegahSubmit = document.getElementById('cegah-submit');

        const sisaCutiHide = document.getElementById('sisa-cuti-hide');

        let totalCuti = 1;

        periode.addEventListener('change', function() {
            periodeOpt.style.display = 'none';
            cutiDB.forEach(cuti => {
                if (periode.value == cuti.periode) {
                    sisaCuti.textContent = cuti.sisa_cuti + ' Hari.';
                    sisaCutiHidden.value = cuti.sisa_cuti;
                    if (cuti.sisa_cuti == 0) {
                        cutiHabisDiv.style.display = 'block';
                        tanggalAwalDiv.style.display = 'none';
                        cutiHabisDiv.querySelector('div').textContent = 'Sisa cuti periode ' + cuti.periode + ' sudah habis, silakan pilih periode lain.';
                    } else {
                        tanggalAwalDiv.style.display = 'block';
                        cutiHabisDiv.style.display = 'none';
                    }
                }
            });
        });

        tanggalAwal.addEventListener('change', function() {
            centangDiv.style.display = 'block';
            centang.disabled = false;
            lamaCuti.textContent = totalCuti + ' Hari.';
            lamaCutiHidden.value = totalCuti;
            sisaCutiHide.value = totalCuti;
            keteranganDiv.style.display = 'flex';
            keterangan.required = true;
            kontakDiv.style.display = 'flex';

            const tglAwal = new Date(tanggalAwal.value);

            if (!tanggalAwal.value) {
                centangDiv.style.display = 'none';
                centang.checked = false;
                centang.disabled = true;
                tanggalAkhirDiv.style.display = 'none';
                tanggalAkhir.value = '';
                tanggalAkhir.disabled = true;
                lamaCuti.textContent = '';
                keteranganDiv.style.display = 'none';
                kontakDiv.style.display = 'none';
            } else if (tglLiburArr.includes(tanggalAwal.value)) {
                spanTglAwal.style.display = 'block';
                tanggalAwal.value = '';
                centangDiv.style.display = 'none';
                centang.checked = false;
                centang.disabled = true;
                tanggalAkhirDiv.style.display = 'none';
                tanggalAkhir.value = '';
                tanggalAkhir.disabled = true;
                lamaCuti.textContent = '';
                keteranganDiv.style.display = 'none';
                tanggalKembali.textContent = '';
                tglMasukKerja.value = '';
                kontakDiv.style.display = 'none';
            } else {
                spanTglAwal.style.display = 'none';
            }

            tglAwal.setDate(tglAwal.getDate() + 1);
            const options = {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            };
            const besok = tglAwal.toLocaleDateString('id-ID', options);
            if (!tanggalAkhir.value) {
                tanggalKembali.textContent = besok;
                tglMasukKerja.value = tglAwal.toISOString().split('T')[0];
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

        tanggalAkhir.addEventListener('change', function() {
            const tglAwal = new Date(tanggalAwal.value);
            const tglAkhir = new Date(tanggalAkhir.value);

            if (tglAwal.getTime() >= tglAkhir.getTime()) {
                tanggalAkhir.value = '';
                spanTglAkhir.style.display = 'block';
                spanTglAkhir.querySelector('small').textContent = 'Tidak bisa memilih tanggal mundur/sama.'
                tanggalKembali.textContent = '';
                tglMasukKerja.value = '';
                lamaCuti.textContent = totalCuti + ' Hari.';
                lamaCutiHidden.value = totalCuti;
                tglAwal.setDate(tglAwal.getDate() + 1);
                const options = {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                };
                const besok = tglAwal.toLocaleDateString('id-ID', options);
                if (!tanggalAkhir.value) {
                    tanggalKembali.textContent = besok;
                    tglMasukKerja.value = tglAwal.toISOString().split('T')[0];
                }
            } else if (tglLiburArr.includes(tanggalAkhir.value)) {
                tanggalAkhir.value = '';
                spanTglAkhir.style.display = 'block';
                spanTglAkhir.querySelector('small').textContent = 'Tidak bisa memilih hari libur anda.'
                lamaCuti.textContent = totalCuti + ' Hari.';
                lamaCutiHidden.value = totalCuti;
                tglAwal.setDate(tglAwal.getDate() + 1);
                const options = {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                };
                const besok = tglAwal.toLocaleDateString('id-ID', options);
                if (!tanggalAkhir.value) {
                    tanggalKembali.textContent = besok;
                    tglMasukKerja.value = tglAwal.toISOString().split('T')[0];
                }
            } else if (!tglAkhir) {
                lamaCuti.textContent = totalCuti + ' Hari.';
                lamaCutiHidden.value = totalCuti;
                tglAwal.setDate(tglAwal.getDate() + 1);
                const options = {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                };
                const besok = tglAwal.toLocaleDateString('id-ID', options);
                if (!tanggalAkhir.value) {
                    tanggalKembali.textContent = besok;
                    tglMasukKerja.value = tglAwal.toISOString().split('T')[0];
                }
            } else {
                spanTglAkhir.style.display = 'none';
                const tglArr = [];
                while (tglAwal <= tglAkhir) {
                    tglArr.push(new Date(tglAwal));
                    tglAwal.setDate(tglAwal.getDate() + 1);
                }
                const tglArrISO = tglArr.map((item) => item.toISOString().split('T')[0]);

                const jumlahHari = [];
                tglArrISO.forEach((tgl) => {
                    if (!tglLiburArr.includes(tgl)) {
                        jumlahHari.push(tgl);
                    }
                });

                // const jumlahHari = new Set();
                // tglArrISO.forEach((tanggal) => jumlahHari.add(tanggal));
                // tglLiburArr.forEach((tanggal) => jumlahHari.add(tanggal));

                lamaCuti.textContent = jumlahHari.length + ' Hari.';
                lamaCutiHidden.value = jumlahHari.length;
                sisaCutiHide.value = jumlahHari.length;

                tglAkhir.setDate(tglAkhir.getDate() + 1);
                const options = {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                };
                const besok = tglAkhir.toLocaleDateString('id-ID', options);
                tanggalKembali.textContent = besok;
                tglMasukKerja.value = tglAwal.toISOString().split('T')[0];
                tanggalAwal.addEventListener('change', function() {
                    if (!tanggalAwal.value) {
                        tanggalKembali.textContent = '';
                        tglMasukKerja.value = '';
                    }
                });
            }

        });

        telp.addEventListener('input', function() {
            telp.value = telp.value.replace(/[^0-9]/g, '');
        });

        keterangan.addEventListener('input', function() {
            btnDiv.style.display = 'block';
            if (!keterangan.value) {
                btnDiv.style.display = 'none';
            }
        });
    });
</script>

<?= $this->endSection(); ?>