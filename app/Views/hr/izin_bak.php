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
        <input type="text" value="<?= $user['nama']; ?>" name="nama" hidden>
        <input type="text" value="<?= $user['departemen']; ?>" name="departemen" hidden>
        <input type="text" value="<?= $user['level']; ?>" name="level" hidden>
        <input type="text" value="<?= $user['nik']; ?>" name="nik" hidden>
        <div class="form-row border-top border-muted form mt-3">
            <div class="form-group col-md-6">
                <label for="alasan_izin">Alasan Izin:</label>
                <select class="form-control" id="alasan_izin" name="alasan_izin">
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
                <select class="form-control" id="alasan_tidak_hadir" name="alasan_tidak_hadir">
                    <option></option>
                    <option value="Pernikahan Anak Karyawan">Pernikahan Anak Karyawan (2hari)</option>
                    <option value="Kematian Suami/Istri Ortu/Mertua Karyawan">Kematian Suami/Istri Ortu/Mertua Karyawan (2hari)</option>
                    <option value="Khitan/Pembabtisan Anak Karyawan">Khitan/Pembabtisan Anak Karyawan (2hari)</option>
                    <option value="Istri Gugur Kandungan">Istri Gugur Kandungan (2hari)</option>
                    <option value="Pernikahan Karyawan">Pernikahan Karyawan (3hari)</option>
                    <option value="Kelahiran Anak Karyawan">Kelahiran Anak Karyawan (3hari)</option>
                    <option value="Kematian Saudara Kandung Karyawan">Kematian Saudara Kandung Karyawan (2hari)</option>
                    <option value="Gugur Kandungan">Gugur Kandungan (sesuai surat dokter)</option>
                </select>
            </div>
        </div>
        <div class="form-row border-top border-muted form mt-3">
            <div class="col-md-6">
                <label for="start_date">Tanggal Izin :</label>
                <input type="date" class="form-control" id="izin_awal" name="izin_awal" onchange="updateEndDate()">
                <span class="bg-danger text-white" id="span_date1" style="display: none;"><small class="ml-3">*Tanngal tidak bisa dipilih, karena merupakan cuti bersama/hari libur.</small></span>
            </div>
            <input style="margin-top : 2.89%" type="number" class="form-control col-md-2 " id="totalIzin" name="totalIzin" readonly value="">
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
        <div class="form-row border-top border-muted form mt-3">
            <div class="col-md-6">
                <div class="form-check" id="centang_div2">
                    <input type="checkbox" class="form-check-input" id="centang_tambahan2"> <!-- end_date_checkbox -->
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
        const izin_akhir = document.getElementById('izin_akhir');



        // Set initial state to disabled and hide extra reason dropdown
        keterangan_waktuInput.hidden = true;
        sampai_denganInput.hidden = true;
        alasan_tidak_hadir_divInput.style.display = 'none';
        endDateDiv.style.display = 'none';
        centangDiv.style.display = 'none';
        centangDiv2.style.display = 'none';
        tglHide.style.display = 'none';
        suratDok.style.display = 'none';

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
            } else if (selectedReason === 'tidak hadir') {
                keterangan_waktuInput.hidden = true;
                sampai_denganInput.hidden = true;
                keterangan_waktuInput.style.display = 'none';
                sampai_denganInput.style.display = 'none';
                alasan_tidak_hadir_div.style.display = 'block';
                centangDiv.style.display = 'block';
                suratDok.style.display = 'none';
                centangDiv.style.display = 'none';
                endDateDiv.style.display = 'block';
            } else if (selectedReason === 'sakit') {
                keterangan_waktuInput.hidden = true;
                sampai_denganInput.hidden = true;
                keterangan_waktuInput.style.display = 'none';
                sampai_denganInput.style.display = 'none';
                alasan_tidak_hadir_div.style.display = 'none';
                centangDiv.style.display = 'block';
                suratDok.style.display = 'block';
            } else if (selectedReason === 'luar kota' || selectedReason === 'izin lain-lain') {
                keterangan_waktuInput.hidden = true;
                sampai_denganInput.hidden = true;
                keterangan_waktuInput.style.display = 'none';
                alasan_tidak_hadir_div.style.display = 'none';
                sampai_denganInput.style.display = 'none';
                centangDiv.style.display = 'block';
                suratDok.style.display = 'none';
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
            }
        });

        endDateCheckbox.addEventListener('change', function() {
            if (endDateCheckbox.checked) {
                endDateDiv.style.display = 'block'; // Show end date when checkbox is checked
                centangDiv2.style.display = 'block'; // Show end date when checkbox is checked
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
        document.getElementById('izin_akhir').addEventListener('change', updateEndDate);

    });
    const cutiBersama = <?= json_encode($cuti_bersama) ?>;

    function updateEndDate() {
        const alasan = document.getElementById('alasan_tidak_hadir').value;
        const izinAwal = document.getElementById('izin_awal').value;

        if (izinAwal && alasan) {
            let endDate = new Date(izinAwal);

            // Menambah hari berdasarkan alasan cuti
            let tambahanHari = 0;

            switch (alasan) {
                case 'Pernikahan Anak Karyawan':
                case 'Kematian Suami/Istri Ortu/Mertua Karyawan':
                case 'Khitan/Pembabtisan Anak Karyawan':
                case 'Istri Gugur Kandungan':
                case 'Kematian Saudara Kandung Karyawan':
                    tambahanHari = 1; // 2 hari
                    break;
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

            // Set izin_akhir sesuai dengan perhitungan akhir
            document.getElementById('izin_akhir').value = endDate.toISOString().split('T')[0];

            // Set nilai total hari cuti
            document.getElementById('totalIzin').value = totalDays;
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