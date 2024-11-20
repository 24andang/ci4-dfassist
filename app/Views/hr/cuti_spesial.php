<?= $this->extend('\Login\layouts\layout') ?>

<?= $this->section('content') ?>
<?= $this->include('\Login\layouts\navbar') ?>

<div class="container mt-5">
    <form action="/hr/cuti_spesial/create" method="post">
        <input type="text" value="<?= session()->get('nik') ?>" name="nik" hidden>
        <input type="text" value="<?= session()->get('inisial') ?>" name="inisial" hidden>
        <input type="text" value="<?= session()->get('nama') ?>" name="nama" hidden>
        <input type="text" value="<?= session()->get('departemen') ?>" name="departemen" hidden>
        <input type="text" value="<?= session()->get('level') ?>" name="level" hidden>
        <div class="row">
            <div class="form-group col-md-6" id="alasan_tidak_hadir_div"> <!-- extra_reason_div --> <!--extra_reason -->
                <input type="text" value="cuti spesial" hidden name="alasan_izin">
                <select id="alasan_cuti_spesial" name="alasan_cuti_spesial" class="form-control" onchange="updateEndDate()">
                    <option value="">Pilih Alasan</option>
                    <option value="Haji">Haji</option>
                    <option value="Melahirkan">Melahirkan</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="start_date">Tanggal Izin :</label>
                <input type="date" class="form-control" id="izin_awal" name="izin_awal" onchange="updateEndDate()">
            </div>
            <div class="col-md-6">
                <label for="end_date">Sampai dengan :</label>
                <input type="date" class="form-control" id="izin_akhir" name="izin_akhir" readonly>
            </div>
            <div class="col-md-6 mt-3">
                <label for="total_cuti_label">Total Hari Cuti: (hari)</label>
                <input style="max-width : 30%" type="number" class="form-control" id="total_cuti_label" name="total_cuti" readonly value="">
                <span class="bg-info text-white" id="span_date1" style="display: none;"><small class="ml-3">*Total hari bertambah karena terdapat Cuti Bersama selama durasi.</small></span>
            </div>
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary mt-3 mb-3 ">Kirim</button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5 class="fst-italic text-muted">*tidak memotong jatah cuti tahunan</h5>
                <h5 class="fst-italic text-muted">*hari terhitung merupakan hari kalender</h5>
                <h5 class="fst-italic text-muted">*jika ada cuti bersama selama durasi cuti, maka jumlah hari ditambahkan dengan cuti bersama</h5>
            </div>
        </div>
    </form>

    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     const alasan = document.getElementById('alasan_cuti_spesial');


        //     alasan.addEventListener('change', function() {
        //         document.getElementById('izin_awal').value = '';
        //     });
        // })


        // Data cuti bersama dengan tanggal dan keterangan dari database
        const cutiBersama = <?= json_encode($cuti_bersama) ?>;

        // Fungsi untuk menyesuaikan izin_akhir dan menghitung total hari cuti
        function updateEndDate() {
            const alasan = document.getElementById('alasan_cuti_spesial').value;
            const izinAwal = document.getElementById('izin_awal').value;

            if (izinAwal && (alasan === 'Haji' || alasan === 'Melahirkan')) {
                let endDate = new Date(izinAwal);

                // Menambah hari berdasarkan alasan cuti
                if (alasan === 'Haji') {
                    endDate.setDate(endDate.getDate() + 39); // Haji: 10 hari
                } else if (alasan === 'Melahirkan') {
                    endDate.setDate(endDate.getDate() + 89); // Melahirkan: 5 hari
                }

                // Menambahkan hari ekstra jika ada cuti bersama di antara izin_awal dan izin_akhir,
                // kecuali jika keterangannya adalah "weekend".
                const originalEndDate = new Date(endDate);
                let extraDays = 0; // Hari ekstra dari cuti bersama

                for (let i = 0; i < cutiBersama.length; i++) {
                    const cutiDate = new Date(cutiBersama[i].tanggal);
                    const keterangan = cutiBersama[i].keterangan;

                    // Jika ada cuti bersama di rentang izin_awal - izin_akhir dan bukan "weekend"
                    if (cutiDate >= new Date(izinAwal) && cutiDate <= originalEndDate && keterangan === 'Cuti Bersama') {
                        extraDays += 1;
                    }
                }

                // Tambahkan hari ekstra ke endDate
                endDate.setDate(endDate.getDate() + extraDays);

                // Set izin_akhir sesuai dengan perhitungan
                document.getElementById('izin_akhir').value = endDate.toISOString().split('T')[0];

                // Menghitung total hari cuti (izin_awal sampai izin_akhir)
                const startDate = new Date(izinAwal);
                const totalDays = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1; // Menambahkan 1 untuk menghitung hari pertama


                // Set nilai total hari cuti
                document.getElementById('total_cuti_label').value = totalDays;

                if (alasan === 'Haji' && document.getElementById('total_cuti_label').value > 40) {
                    document.getElementById('span_date1').style.display = 'block';
                } else if (alasan === 'Melahirkan' && document.getElementById('total_cuti_label').value > 90) {
                    document.getElementById('span_date1').style.display = 'block';
                } else {
                    document.getElementById('span_date1').style.display = 'none';
                }
            }
        }
    </script>


    <?= $this->endSection(); ?>