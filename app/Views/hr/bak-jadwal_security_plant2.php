<?= $this->extend('\layouts\layout\main') ?>

<?= $this->section('content') ?>
<?= $this->include('\layouts\layout\navbar') ?>


<div class="card-deck mt-5 text-dark">
    <div class="card border-dark" style="max-width: 18rem;">
        <div class="card-body">
            <?php if (session()->getFlashdata('pesan_sukses')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('pesan_sukses') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('pesan_gagal')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('pesan_gagal') ?>
                </div>
            <?php endif; ?>
            <form method="post" action="/hr/input/regu_security">
                <div class="form-group">
                    <label for="Nama">Daftar Personel Plant 2</label>
                    <select class="form-control" id="nama-1" name="nama-1" required>
                        <option id="nama-1-opt">--Nama Security--</option>
                        <?php foreach ($security as $sec) : ?>
                            <option value="<?= $sec['nama']; ?>"><?= $sec['nama']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group" hidden>
                    <select class="form-control" id="nama-2" name="nama-2" required>
                        <option id="nama-2-opt">--Pilih Personel 2--</option>
                        <?php foreach ($security as $sec) : ?>
                            <option value="<?= $sec['nama']; ?>"><?= $sec['nama']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="text-danger" id="span-personel"><small>*Personel 1 & 2 tidak boleh sama.</small></span>
                </div>
            </form>
        </div>
    </div>

    <!-- Kertu Upload CSV-->
    <div class="card border-dark" style="max-width: 18rem;">
        <div class="card-body">
            <?php if (session()->getFlashdata('csv_sukses')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('csv_sukses') ?>
                </div>
            <?php endif; ?>
            <h5 class="card-title">Jadwal Bulanan</h5>
            <form method="post" action="/hr/input/csv_security" enctype="multipart/form-data" id="csv-form">
                <div class="form-group">
                    <label for="Periode">Periode</label>
                    <div class="row">
                        <div class="col-6">
                            <select class="form-control" name="bulan" id="bulan">
                                <option value="01">Jan</option>
                                <option value="02">Feb</option>
                                <option value="03">Mar</option>
                                <option value="04">Apr</option>
                                <option value="05">Mei</option>
                                <option value="06">Jun</option>
                                <option value="07">Jul</option>
                                <option value="08">Agu</option>
                                <option value="09">Sep</option>
                                <option value="10">Okt</option>
                                <option value="11">Nov</option>
                                <option value="12">Des</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <select class="form-control" name="tahun" id="tahun">
                                <option value="<?= date('Y'); ?>"><?= date('Y'); ?></option>
                                <option value="<?= date('Y') + 1; ?>"><?= date('Y') + 1; ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="csv-file" class="form-label">Upload File</label>
                    <input class="form-control" type="file" id="csv-file" accept=".csv" name="csv-file" required>
                    <span class="text-danger" id="span-csv"><small>*Format file harus csv.</small></span>
                </div>
                <button type="submit" class="btn btn-primary" id="btn-submit">Submit</button>
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#jadwalModal" id="btn-show-jadwal">Show</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Jadwal -->
<div class="modal fade" id="jadwalModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog text-dark">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Jadwal Hari Libur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="modal-body">
        <table class="table table-striped bg-light">
            <thead>
                <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Personel 1</th>
                </tr>
            </thead>
            <tbody id="tabel-jadwal">
            </tbody>
        </table>
    </div>
</div>
</div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        //from db
        const jadwalDB = <?= json_encode($jadwal) ?>;
        const tanggal = jadwalDB.map((item) => item.tanggal);

        //view only
        const nama1 = document.getElementById('nama-1');
        const nama1Opt = document.getElementById('nama-1-opt');
        const nama2 = document.getElementById('nama-2');
        const nama2Opt = document.getElementById('nama-2-opt');
        const spanPersonel = document.getElementById('span-personel');
        const btnSubmit = document.getElementById('btn-submit');
        const bulan = document.getElementById('bulan');
        const tahun = document.getElementById('tahun');
        const tabelJadwal = document.getElementById('tabel-jadwal');
        const filterBulan = document.getElementById('tabel-bulan');
        const filterTahun = document.getElementById('tabel-tahun');
        const btnShowJadwal = document.getElementById('btn-show-jadwal');
        const blnOpt = document.getElementById('bln-opt');
        const thnOpt = document.getElementById('thn-opt');

        const spanCsv = document.getElementById('span-csv');
        const csvForm = document.getElementById('csv-form');
        const csvInput = document.getElementById('csv-file');

        nama2.disabled = true;
        spanPersonel.style.display = 'none';

        spanCsv.style.display = 'none';

        // kartu regu
        nama1.addEventListener('change', function() {
            nama2.disabled = false;
            nama1Opt.style.display = 'none';
        });

        nama2.addEventListener('change', function() {
            nama2Opt.style.display = 'none';
            if (nama2.value == nama1.value) {
                spanPersonel.style.display = 'block';
                nama2.value = null;
            } else {
                spanPersonel.style.display = 'none';
            }
        });

        // kartu csv
        csvForm.addEventListener('submit', function(event) {
            let csvFile = csvInput.value;
            let fileExt = /(\.csv)$/i;
            //note : fileExt merupakan regex.
            // penulisan regex diawal/akhiri dengan /
            // \ digunakan untuk force . menjadi string
            // i adalah fragment untuk mengabaikan case-sensitive

            if (!fileExt.exec(csvFile)) {
                spanCsv.style.display = 'block';
                event.preventDefault();
            } else {
                spanCsv.style.display = 'none';
            }
        });

        tabelJadwal.innerHTML = '';

        btnShowJadwal.addEventListener('click', function() {
            jadwalDB.forEach(jadwal => {
                const tgl = new Date(jadwal.tanggal);
                const bln = tgl.getMonth() + 1;
                const thn = tgl.getFullYear();

                if (parseInt(bulan.value) === bln && parseInt(tahun.value) === thn) {
                    const tr = document.createElement('tr');
                    const tdTanggal = document.createElement('td');
                    tdTanggal.textContent = jadwal.tanggal;
                    const tdPersonel1 = document.createElement('td');
                    tdPersonel1.textContent = jadwal.nama_1;

                    tr.appendChild(tdTanggal);
                    tr.appendChild(tdPersonel1);

                    tabelJadwal.appendChild(tr);
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>