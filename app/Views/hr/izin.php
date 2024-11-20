<?= $this->extend('\Login\layouts\layout') ?>

<?= $this->section('content') ?>
<?= $this->include('\Login\layouts\navbar') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h1>Formulir Izin : <?= $user['nama']; ?></h1>
        </div>
        <div class="col">
            <?php if (session()->getFlashdata('message')) : ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('message') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <form action="/hr/izin/create" method="post">
        <input type="text" value="<?= $user['id']; ?>" name="id" hidden>
        <input type="text" value="<?= $user['nama']; ?>" name="nama" hidden>
        <input type="text" value="<?= $user['departemen']; ?>" name="departemen" hidden>
        <input type="text" value="<?= $user['level']; ?>" name="level" hidden>
        <input type="text" value="<?= $user['nik']; ?>" name="nik" hidden>
        <div class="form-row border-top border-muted form mt-3">
            <div class="form-group col-md-6">
                <label for="alasan_izin">Alasan Izin:</label>
                <select class="form-control" id="alasan_izin" name="alasan_izin" onchange="resetDates(); updateEndDate()">
                    <option>--Pilih Alasan Izin--</option>
                    <option value="datang terlambat">Datang Terlambat</option>
                    <option value="pulang lebih awal">Pulang Lebih Awal</option>
                    <option value="meninggalkan kantor">Meninggalkan Kantor</option>
                    <option value="sakit">Sakit</option>
                    <option value="luar kota">Luar Kota</option>
                    <option value="tidak hadir">Tidak Hadir</option>
                    <option value="izin lain-lain">Lain-lain</option>
                </select>
            </div>
            <div class="form-group col-md-4 mt-4 ml-3" id="surat_dokter">
                <small>* Harap kumpulkan surat keterangan dokter ke HR.</small>
            </div>
            <div class="form-group col-md-3" id="keterangan_waktu"> <!-- start_time -->
                <label for="keterangan_waktu">Keterangan Waktu:</label>
                <input type="time" class="form-control" name="keterangan_waktu" id="waktu_awal">
            </div>
            <div class="form-group col-md-3" id="sampai_dengan"> <!-- end_time -->
                <label for="sampai_dengan">Sampai Dengan:</label>
                <input type="time" class="form-control" name="sampai_dengan" id="waktu_akhir">
            </div>
            <div class="form-group col-md-6" id="alasan_tidak_hadir_div"> <!-- extra_reason_div --> <!--extra_reason -->
                <label for="alasan_tidak_hadir">Alasan Tidak Hadir:</label>
                <select class="form-control" id="alasan_tidak_hadir" name="alasan_tidak_hadir" onchange="updateEndDate(); resetDates()">
                    <option id="alasan-opt">--Pilih Alasan--</option>
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
        </div>
        <div class="form-row border-top border-muted form mt-3">
            <div class="col-md-6">
                <label for="start_date">Tanggal Izin :</label>
                <input type="date" class="form-control" id="izin_awal" name="izin_awal" onchange="updateEndDate()" required>
                <span class="bg-danger text-white" id="span_date1" style="display: none;"><small class="ml-3">*Tanngal tidak bisa dipilih, karena merupakan cuti bersama/hari libur.</small></span>
            </div>
            <div id="total_div" class="col-md-3">
                <label for=" totalIzin">Jumlah Hari :</label>
                <input type="number" style="width: 45%;" class="form-control" id="totalIzin" name="totalIzin" readonly value="">
            </div>
            <!-- <div class="col-md-2 ml-2 alert alert-info" id="total_cuti_label" style="margin-top: 3%;"></div> -->
            <div class="col-md-6">
                <div class="form-check" id="centang_div">
                    <input type="checkbox" class="form-check-input" id="centang_tambahan"> <!-- end_date_checkbox -->
                    <label class="form-check-label" for="centang_tambahan"><small>Centang jika lebih dari satu hari</small></label>
                </div>
            </div>
        </div>
        <div class="form-row" id="end_date_div">
            <div class="col-md-6">
                <label for="end_date">Sampai dengan :</label>
                <input type="date" class="form-control" id="izin_akhir" name="izin_akhir" readonly>
                <span class="bg-danger text-white" id="span_date2" style="display: none;"><small class="ml-3">*Tanngal tidak bisa dipilih, karena merupakan cuti bersama/hari libur.</small></span>
            </div>
        </div>

        <!--let-->
        <div class="form-row form mt-3">
            <div class="col-md-6">
                <div class="form-check" id="centang_div2">
                    <input type="checkbox" class="form-check-input" id="centang_tambahan2">
                    <label class="form-check-label" for="centang_tambahan2"><small>Centang jika melewati hari libur</small></label>
                </div>
            </div>
        </div>
        <div class="form-row" id="tgl_hide">
            <div class="col-md-6">
                <label for="izin_awal2">Tanggal Izin :</label>
                <input type="date" class="form-control" id="izin_awal2" name="izin_awal2">
            </div>
            <div class="col-md-6">
                <label for="izin_akhir2">Sampai dengan :</label>
                <input type="date" class="form-control" id="izin_akhir2" name="izin_akhir2">
            </div>
        </div>


        <div class="form-row border-top border-bottom border-muted form mt-3">
            <div class="form-group col-md-12">
                <label for="reason">Keterangan Izin</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
            </div>
            <div class="form-group col-md-6">
                <label for="reason">Kendaraan yang digunakan</label>
                <textarea class="form-control" id="kendaraan" name="kendaraan" rows="1"></textarea>
            </div>
            <div class="form-group col-md-6">
                <label for="reason">Pengemudi</label>
                <textarea class="form-control" id="pengemudi" name="pengemudi" rows="1"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3 mb-3 ">Kirim</button>
    </form>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alasan_izinSelect = document.getElementById('alasan_izin');
        const keterangan_waktuInput = document.getElementById('keterangan_waktu');
        const sampai_denganInput = document.getElementById('sampai_dengan');
        const alasan_tidak_hadir_divInput = document.getElementById('alasan_tidak_hadir_div');
        const endDateDiv = document.getElementById('end_date_div');
        const endDateCheckbox = document.getElementById('centang_tambahan');
        const endDateCheckbox2 = document.getElementById('centang_tambahan2');
        const centangDiv = document.getElementById('centang_div');
        const centangDiv2 = document.getElementById('centang_div2');
        const tglHide = document.getElementById('tgl_hide');
        const suratDok = document.getElementById('surat_dokter');
        const izin_awal = document.getElementById('izin_awal');
        const izin_akhir = document.getElementById('izin_akhir');
        const totalIzin = document.getElementById('totalIzin');
        const total_div = document.getElementById('total_div');
        const waktu_awal = document.getElementById('waktu_awal');
        const waktu_akhir = document.getElementById('waktu_akhir');
        const alasan_tidak_hadir = document.getElementById('alasan_tidak_hadir');
        const alasanOpt = document.getElementById('alasan-opt');


        // Set initial state to disabled and hide extra reason dropdown
        keterangan_waktuInput.hidden = true;
        sampai_denganInput.hidden = true;
        alasan_tidak_hadir_divInput.style.display = 'none';
        endDateDiv.style.display = 'none';
        centangDiv.style.display = 'none';
        centangDiv2.style.display = 'none';
        tglHide.style.display = 'none';
        suratDok.style.display = 'none';
        total_div.style.display = 'none';

        alasan_izinSelect.addEventListener('change', function() {
            const selectedReason = alasan_izinSelect.value;

            if (selectedReason === 'datang terlambat' || selectedReason === 'pulang lebih awal') {
                keterangan_waktuInput.hidden = false;
                sampai_denganInput.hidden = true;
                keterangan_waktuInput.style.display = 'block';
                sampai_denganInput.style.display = 'block';
                alasan_tidak_hadir_div.style.display = 'none';
                centangDiv.style.display = 'none';
                suratDok.style.display = 'none';
                tglHide.style.display = 'none';
                endDateDiv.style.display = 'none';
                centangDiv2.style.display = 'none';
                izin_awal.value = "";
                izin_akhir.disabled = true;
                total_div.style.display = 'none';
                waktu_awal.value = "";
                waktu_awal.required = true;
                waktu_akhir.value = "";
                waktu_akhir.required = false;
                alasan_tidak_hadir.value = "";
            } else if (selectedReason === 'meninggalkan kantor') {
                keterangan_waktuInput.hidden = false;
                sampai_denganInput.hidden = false;
                keterangan_waktuInput.style.display = 'block';
                sampai_denganInput.style.display = 'block';
                alasan_tidak_hadir_div.style.display = 'none';
                centangDiv.style.display = 'none';
                suratDok.style.display = 'none';
                tglHide.style.display = 'none';
                endDateDiv.style.display = 'none';
                centangDiv2.style.display = 'none';
                izin_awal.value = "";
                izin_akhir.disabled = true;
                total_div.style.display = 'none';
                waktu_awal.value = "";
                waktu_awal.required = true;
                waktu_akhir.value = "";
                waktu_akhir.required = true;
                alasan_tidak_hadir.value = "";
            } else if (selectedReason === 'tidak hadir') {
                keterangan_waktuInput.hidden = true;
                sampai_denganInput.hidden = true;
                keterangan_waktuInput.style.display = 'none';
                sampai_denganInput.style.display = 'none';
                alasan_tidak_hadir_div.style.display = 'block';
                centangDiv.style.display = 'none';
                suratDok.style.display = 'none';
                centangDiv2.style.display = 'none';
                endDateDiv.style.display = 'block';
                total_div.style.display = 'block';
                izin_awal.value = "";
                izin_akhir.value = "";
                waktu_awal.value = "";
                waktu_awal.required = false;
                waktu_akhir.required = false;
                waktu_akhir.value = "";
                izin_awal.readOnly = true;
                izin_akhir.readOnly = true;
                alasan_tidak_hadir.addEventListener('change', function() {
                    if (alasan_tidak_hadir.value !== 'Gugur Kandungan') {
                        izin_awal.readOnly = false;
                        izin_akhir.readOnly = true;
                        alasanOpt.style.display = 'none';
                    } else {
                        izin_awal.readOnly = false;
                        izin_akhir.readOnly = false;
                        alasanOpt.style.display = 'none';
                    }
                });
            } else if (selectedReason === 'sakit') {
                keterangan_waktuInput.hidden = true;
                sampai_denganInput.hidden = true;
                keterangan_waktuInput.style.display = 'none';
                sampai_denganInput.style.display = 'none';
                alasan_tidak_hadir_div.style.display = 'none';
                centangDiv.style.display = 'block';
                centangDiv2.style.display = 'none';
                suratDok.style.display = 'block';
                total_div.style.display = 'block';
                izin_awal.value = "";
                izin_akhir.value = "";
                izin_akhir.disabled = false;
                waktu_awal.value = "";
                waktu_akhir.value = "";
                waktu_awal.required = false;
                waktu_akhir.required = false;
                alasan_tidak_hadir.value = "";
            } else if (selectedReason === 'luar kota' || selectedReason === 'izin lain-lain') {
                keterangan_waktuInput.hidden = true;
                sampai_denganInput.hidden = true;
                keterangan_waktuInput.style.display = 'none';
                alasan_tidak_hadir_div.style.display = 'none';
                sampai_denganInput.style.display = 'none';
                centangDiv.style.display = 'block';
                centangDiv2.style.display = 'none';
                suratDok.style.display = 'none';
                total_div.style.display = 'block';
                izin_awal.value = "";
                izin_akhir.value = "";
                izin_akhir.disabled = false;
                waktu_awal.value = "";
                waktu_akhir.value = "";
                waktu_awal.required = false;
                waktu_akhir.required = false;
                alasan_tidak_hadir.value = "";
            } else {
                keterangan_waktuInput.hidden = true;
                sampai_denganInput.hidden = true;
                keterangan_waktuInput.style.display = 'block';
                sampai_denganInput.style.display = 'block';
                alasan_tidak_hadir_div.style.display = 'none';
                centangDiv.style.display = 'none';
                suratDok.style.display = 'none';
                tglHide.style.display = 'none';
                endDateDiv.style.display = 'none';
                izin_awal.value = "";
                izin_akhir.value = "";
                izin_akhir.disabled = false;
                waktu_awal.value = "";
                waktu_akhir.value = "";
                waktu_awal.required = false;
                waktu_akhir.required = false;
                alasan_tidak_hadir.value = "";
            }
        });

        endDateCheckbox.addEventListener('change', function() {
            if (endDateCheckbox.checked) {
                endDateDiv.style.display = 'block'; // Show end date when checkbox is checked
                centangDiv2.style.display = 'none'; // Show end date when checkbox is checked
            } else {
                endDateDiv.style.display = 'none'; // Hide end date when checkbox is unchecked
                centangDiv2.style.display = 'none';
                tglHide.style.display = 'none'; // Hide end date when checkbox is unchecked
            }
        });

        endDateCheckbox2.addEventListener('change', function() {
            if (endDateCheckbox2.checked) {
                tglHide.style.display = 'block'; // Show end date when checkbox is checked
            } else {
                tglHide.style.display = 'none'; // Show end date when checkbox is checked
            }
        });

        document.getElementById('izin_awal').addEventListener('change', updateEndDate);
        document.getElementById('izin_awal').addEventListener('change', span);
        document.getElementById('izin_akhir').addEventListener('change', updateEndDate);
        document.getElementById('izin_akhir').addEventListener('change', span);

    });


    const cutiBersama = <?= json_encode($cuti_bersama) ?>;
    const cutiBersama1 = <?= json_encode(array_column($cuti_bersama, 'tanggal')) ?>;


    function span() {

        const date1 = document.getElementById('izin_awal').value;
        const date2 = document.getElementById('izin_akhir').value;

        if (cutiBersama1.includes(document.getElementById('izin_awal').value)) {
            document.getElementById('izin_awal').value = '';
            document.getElementById('span_date1').style.display = 'block';
            document.getElementById('totalIzin').value = '';
            return;
        } else if (cutiBersama1.includes(document.getElementById('izin_akhir').value)) {
            document.getElementById('izin_akhir').value = '';
            document.getElementById('span_date2').style.display = 'block';
            document.getElementById('totalIzin').value = "";
            return;
        } else {
            document.getElementById('span_date1').style.display = 'none';
        }

    }

    function resetDates() {
        // Set nilai izin_awal dan izin_akhir menjadi null
        document.getElementById('izin_awal').value = null;
        document.getElementById('izin_akhir').value = null;


        // Reset total cuti label
        document.getElementById('totalIzin').value = '';
    }

    // menghitung hari alasan_izin (kecuali alasan_tidak hadir)
    function updateEndDate() {
        const date1 = document.getElementById('izin_awal').value;
        const date2 = document.getElementById('izin_akhir').value;

        let jumlahHari = 1;



        if (date2) {
            const t1 = new Date(date1);
            const t2 = new Date(date2);

            // Hitung selisih hari
            let diffTime = Math.abs(t2 - t1);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // Termasuk date1

            // Hitung jumlah hari dengan mengabaikan tanggal di cutiBersama1
            for (let i = 0; i < cutiBersama1.length; i++) {
                const cutiDate = new Date(cutiBersama1[i]);
                if (cutiDate > t1 && cutiDate < t2) {
                    diffDays--;
                }
            }

            jumlahHari = diffDays;
        }

        document.getElementById('totalIzin').value = jumlahHari;
        updateEndDate1();
    }

    // menghitung hari alasan_tidak
    function updateEndDate1() {
        const alasan = document.getElementById('alasan_tidak_hadir').value;
        const izinAwal = document.getElementById('izin_awal').value;

        if (izinAwal && alasan) {
            let endDate = new Date(izinAwal);

            // Menambah hari berdasarkan alasan cuti
            let tambahanHari = 1;

            switch (alasan) {
                case 'Kematian Saudara Kandung Karyawan':
                case 'Kakek/Nenek Meninggal':
                    tambahanHari = 0; // 1 hari
                    break;
                case 'Pernikahan Anak Karyawan':
                case 'Kematian Suami/Istri Ortu/Mertua Karyawan':
                case 'Khitan/Pembabtisan Anak Karyawan':
                    tambahanHari = 1; // 2 hari
                    break;
                case 'Istri Gugur Kandungan':
                case 'Pernikahan Karyawan':
                case 'Kelahiran Anak Karyawan':
                    tambahanHari = 2; // 3 hari
                    break;
                case 'Gugur Kandungan':
                    // Tidak ada penambahan hari tetap, berdasarkan surat dokter
                    break;
                default:
                    break;
            }

            // Tambahkan hari ke endDate
            if (tambahanHari > 0) {
                endDate.setDate(endDate.getDate() + tambahanHari);
            }

            // Menghitung total hari cuti (izin_awal sampai izin_akhir) dengan melewati cuti bersama
            let totalDays = 0;
            let currentDate = new Date(izinAwal);

            while (currentDate <= endDate) {
                let isCutiBersama = false;

                // Cek apakah tanggal saat ini adalah cuti bersama
                for (let i = 0; i < cutiBersama.length; i++) {
                    const cutiDate = new Date(cutiBersama[i].tanggal);
                    if (currentDate.toISOString().split('T')[0] === cutiDate.toISOString().split('T')[0]) {
                        isCutiBersama = true;
                        break;
                    }
                }

                // Jika bukan cuti bersama, hitung sebagai hari cuti
                if (!isCutiBersama) {
                    totalDays++;
                } else {
                    // Tambah satu hari ekstra untuk menggantikan cuti bersama
                    endDate.setDate(endDate.getDate() + 1);
                }

                // Lanjutkan ke hari berikutnya
                currentDate.setDate(currentDate.getDate() + 1);
            }
            if (document.getElementById('alasan_tidak_hadir').value !== 'Gugur Kandungan') {
                // Set izin_akhir sesuai dengan perhitungan akhir
                // Set nilai total hari cuti
                document.getElementById('izin_akhir').value = endDate.toISOString().split('T')[0];
                document.getElementById('totalIzin').value = totalDays;
            } else {
                document.getElementById('izin_akhir').readOnly = false;
            }

        }
    }

    // Fungsi untuk mereset input tanggal
    function resetTanggal() {
        document.getElementById('izin_awal').value = ''; // Reset date1
        document.getElementById('izin_akhir').value = ''; // Reset date2
        document.getElementById('totalIzin').value = ''; // Kosongkan total izin
        document.getElementById('waktu_awal').value = ''; // Kosongkan jam jam akhir
        document.getElementById('span_date1').style.display = 'none'; // Sembunyikan span error date1
        document.getElementById('span_date2').style.display = 'none'; // Sembunyikan span error date2
        document.getElementById('izin_akhir').readOnly = false;
    }
    // Event listener untuk mereset tanggal setiap kali alasan diubah
    document.getElementById('alasan_tidak_hadir').addEventListener('change', resetTanggal);
    document.getElementById('alasan_izin').addEventListener('change', resetTanggal);
</script>
<?= $this->endSection() ?>