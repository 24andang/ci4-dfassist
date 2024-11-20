<?= $this->extend('\Login\layouts\layout') ?>

<?= $this->section('content') ?>
<?= $this->include('\Login\layouts\navbar') ?>
<form action="<?= base_url('/hr/cuti/submit'); ?>" method="post">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1>Formulir Cuti : <?= session()->get('nama') ?></h1>
                <h5 class="fst-italic text-muted"><?= session()->get('jabatan') ?> - <?= session()->get('departemen') ?></h5>
                <h5 class="fst-italic text-muted">( Join per : <?= session()->get('tgl_join') ?> )</h5>
            </div>

            <div class="form-group col-md-2">
                <label for="periode">Periode:</label>
                <select id="periode" name="periode" class="form-control" onchange="updateSisaCuti()" required>
                    <option value="">Pilih Periode</option>
                    <?php foreach ($periode_options as $periode): ?>
                        <option value="<?= $periode; ?>" name="periode">
                            <?= $periode; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="sisa_cuti">Sisa Hak Cuti :</label>
                <input type="number" class="form-control" id="sisa_cuti" name="sisa_cuti" readonly>
            </div>
        </div>

        <?php if (session()->getFlashdata('pass_cuti')) : ?>
            <div class="alert alert-info mt-3">
                <?= session()->getFlashdata('pass_cuti'); ?>
            </div>
        <?php elseif (session()->getFlashdata('block_cuti')): ?>
            <div class="alert alert-danger mt-3">
                <?= session()->getFlashdata('block_cuti'); ?>
            </div>
        <?php endif; ?>
        <div id="cuti_habis" class="mt-5">
            <div class="alert alert-info">
                <h2>Hak cuti untuk periode tersebut sudah habis. Silakan pilih periode lain.</h2>
            </div>
        </div>
        <div id="form_tampil">
            <input type="text" value="<?= session()->get('nik') ?>" name="nik" hidden>
            <input type="text" value="<?= session()->get('inisial') ?>" name="inisial" hidden>
            <input type="text" value="<?= session()->get('nama') ?>" name="nama" hidden>
            <input type="text" value="<?= session()->get('departemen') ?>" name="departemen" hidden>
            <input type="text" value="<?= session()->get('level') ?>" name="level" hidden>
            <input type="text" value="cuti" hidden name="alasan_izin">
            <p id="sisa_cuti_hidden"></p>
            <div class="form-row border-top border-muted form mt-3">
                <div class="col-md-6">
                    <label for="izin_awal">Tanggal Cuti :</label>
                    <input type="date" class="form-control" id="izin_awal" name="izin_awal" onchange="calculateTotalDays()" required>
                    <span class="bg-danger text-white" id="span_date1" style="display: none;"><small class="ml-3">*Tanngal tidak bisa dipilih, karena merupakan cuti bersama/hari libur.</small></span>
                </div>
                <div class="col-md-6 mt-4">
                    <input type="checkbox" id="checkbox1" name="checkbox1">
                    <label for="checkbox1"><small>Centang jika lebih dari satu hari.</small></label>
                </div>
                <div class="col-md-6" id="day2_div">
                    <label for="izin_akhir">Sampai dengan :</label>
                    <input type="date" class="form-control" id="izin_akhir" name="izin_akhir" onchange="calculateTotalDays()">
                    <span class="bg-danger text-white" id="span_date2" style="display: none;"><small class="ml-3">*Tanngal tidak bisa dipilih, karena merupakan cuti bersama/hari libur.</small></span>
                </div>
            </div>
            <div class="form-row border-top border-muted form mt-3" id="check2_div">
                <div class="col-md-6 mt-4">
                    <input type="checkbox" name="checkbox2" id="checkbox2">
                    <label for="checkbox2"><small>Centang jika melewati hari libur.</small></label>
                </div>
            </div>
            <div class="form-row form mt-3" id="day3_div">
                <div class="col-md-6">
                    <label for="izin_awal2">Tanggal Cuti :</label>
                    <input type="date" class="form-control" id="izin_awal2" name="izin_awal2">
                </div>
                <div class="col-md-6" id="day2_div">
                    <label for="izin_akhir2">Sampai dengan :</label>
                    <input type="date" class="form-control" id="izin_akhir2" name="izin_akhir2">
                </div>
            </div>
            <div class="form-row border-top border-muted form mt-3">
                <div class="col-md-6">
                    <label for="total_cuti">Lama Cuti (Hari) : </label>
                    <input style="max-width : 30%" type="number" class="form-control" id="total_cuti" name="total_cuti" readonly value="">
                    <h5 class="fst-italic text-muted">*Pastikan tidak lebih dari "Sisa Hak Cuti"</h5>
                </div>
                <div class="col-md-6">
                    <label for="start_date">Tanggal Kembali Masuk Kerja :</label>
                    <input type="date" class="form-control" id="tgl_masuk_kerja" name="tgl_masuk_kerja" readonly>
                </div>
            </div>
            <div class="form-row border-top border-muted form mt-3">
                <label for="alasan_izin">Keperluan Cuti :</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" required>
            </div>
            <div class="form-row border-top border-muted form mt-3">
                <label for="alamat">Alamat Selama Cuti :</label>
                <input type="text" class="form-control" id="alamat" name="alamat">
            </div>
            <div class="form-row border-top border-muted form mt-3">
                <label for="telp">No Telepon :</label>
                <input type="tel" class="form-control" id="telp" name="telp">
            </div>
            <div id="submit">
                <button type="submit" class="btn btn-primary mt-3 mb-3" id="btn_submit">Kirim</button>
            </div>
        </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="cutikurang" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="submitModalLabel">Oppss...</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                "Sisa Hak Cuti" anda tidak cukup
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Kirim</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {

        var formTampil = document.getElementById('form_tampil');
        var cutiHabis = document.getElementById('cuti_habis');

        formTampil.style.display = 'none';
        cutiHabis.style.display = 'none';

        document.getElementById('izin_awal').addEventListener('change', hitungHari);
        document.getElementById('izin_akhir').addEventListener('change', hitungHari);

    }

    function updateSisaCuti() {
        var periode = document.getElementById("periode").value;
        var sisaCutiField = document.getElementById("sisa_cuti");
        var sisaCutiData = <?= json_encode($sisa_cuti_data); ?>;
        var formTampil = document.getElementById('form_tampil');
        let cutiHabis = document.getElementById('cuti_habis');
        let sisaHide = document.getElementById('sisa_cuti_hidden');
        let sisaForm = document.getElementById('sisa_cuti_form');
        let totalCuti = document.getElementById('total_cuti');
        let submit = document.getElementById('submit');
        let submit_none = document.getElementById('submit_none');


        sisaCutiField.value = sisaCutiData[periode] || 0;

        if (sisaCutiField.value == 0) {
            formTampil.style.display = 'none';
            cutiHabis.style.display = 'block';
        } else {
            formTampil.style.display = 'block';
            cutiHabis.style.display = 'none';
        }

        sisaHide.innerHTML = "<input type='number' value=" + sisaCutiField.value + " hidden name='sisa_cuti_hidden' id='sisa_cuti_form'>";
    }

    const date1 = document.getElementById('izin_awal');
    const date2 = document.getElementById('izin_akhir');
    const date3 = document.getElementById('izin_awal2');
    const date4 = document.getElementById('izin_akhir2');
    const date5 = document.getElementById('tgl_masuk_kerja');

    // Ketika date1 berubah, perbarui atribut min pada date2
    date1.addEventListener('change', function() {
        date2.min = date1.value;
        date3.min = date2.value;
        date4.min = date3.value;
    });
    date2.addEventListener('change', function() {
        date3.min = date2.value;
    });
    date3.addEventListener('change', function() {
        date4.min = date3.value;
    });
    date4.addEventListener('change', function() {
        date5.min = date4.value;
    });

    const cutiBersama = <?= json_encode(array_column($cuti_bersama, 'tanggal')) ?>;

    // Fungsi untuk menghitung jumlah hari
    function hitungHari() {
        const date1 = document.getElementById('izin_awal').value;
        const date2 = document.getElementById('izin_akhir').value;
        const date3 = document.getElementById('tgl_masuk_kerja').value;

        // Set jumlah hari default menjadi 1 ketika date1 ada
        let jumlahHari = 1;

        // Jika date1 ada di cutiBersama, jumlah hari adalah 0
        if (cutiBersama.includes(date1)) {
            document.getElementById('izin_awal').value = '';
            document.getElementById('total_cuti').value = '';
            document.getElementById('span_date1').style.display = 'block';
            document.getElementById('total_cuti').innerHTML = jumlahHari - 1;
            return;
        } else {
            document.getElementById('span_date1').style.display = 'none';
        }

        if (date1 && cutiBersama.includes(date2)) {
            document.getElementById('izin_akhir').value = '';
            document.getElementById('span_date2').style.display = 'block';
            document.getElementById('total_cuti').value = jumlahHari;
            return;
        } else {
            document.getElementById('span_date2').style.display = 'none';
        }

        if (date2) {
            const t1 = new Date(date1);
            const t2 = new Date(date2);

            // Hitung selisih hari
            let diffTime = Math.abs(t2 - t1);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // Termasuk date1

            // Hitung jumlah hari dengan mengabaikan tanggal di cutiBersama
            for (let i = 0; i < cutiBersama.length; i++) {
                const cutiDate = new Date(cutiBersama[i]);
                if (cutiDate > t1 && cutiDate < t2) {
                    diffDays--;
                }
            }

            jumlahHari = diffDays;
        }

        document.getElementById('total_cuti').value = jumlahHari;

        // Logika untuk mengisi date3
        let t3;
        if (date2) {
            t3 = new Date(date2); // Gunakan date2 jika ada
        } else {
            t3 = new Date(date1); // Gunakan date1 jika date2 tidak ada
        }

        // Cari hari aktif (tidak termasuk cuti bersama)
        t3.setDate(t3.getDate() + 1); // Tambahkan 1 hari
        while (cutiBersama.includes(t3.toISOString().split('T')[0])) {
            t3.setDate(t3.getDate() + 1); // Tambah lagi jika masuk cuti bersama
        }

        document.getElementById('tgl_masuk_kerja').value = t3.toISOString().split('T')[0]; // Set nilai date3 secara otomatis


    }

    const day2div = document.getElementById('day2_div');
    const day3div = document.getElementById('day3_div');
    const check1 = document.getElementById('checkbox1');
    const check2 = document.getElementById('checkbox2');
    const check2div = document.getElementById('check2_div');

    day2div.style.display = 'none';
    day3div.style.display = 'none';
    check2.style.display = 'none';
    check2div.style.display = 'none';


    check1.addEventListener('change', function() {
        if (check1.checked) {
            day2div.style.display = 'block';
            check2.style.display = 'block';
            `check2div`.style.display = 'none';
        } else {
            day2div.style.display = 'none';
            check2.style.display = 'none';
            day3div.style.display = 'none';
            check2div.style.display = 'none';
        };
    });

    check2.addEventListener('change', function() {
        if (check2.checked) {
            day3div.style.display = 'block';
        } else {
            day3div.style.display = 'none';
        };
    });

    // Tambahkan event listener untuk setiap input tanggal
    document.getElementById('izin_awal').addEventListener('change', calculateTotalCuti);
    document.getElementById('izin_akhir').addEventListener('change', calculateTotalCuti);
    document.getElementById('izin_awal2').addEventListener('change', calculateTotalCuti);
    document.getElementById('izin_akhir2').addEventListener('change', calculateTotalCuti);
</script>
<?= $this->endSection() ?>