<?= $this->extend('Login/layouts/layout'); ?>
<?= $this->section('content'); ?>
<?= $this->include('Login/layouts/navbar'); ?>

<div class="container mt-5">

    <?php if (session()->getFlashdata('done')) : ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('done'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <form method="post" action="/berita_acara/batalkan_by_hr">
        <div class="card-deck">
            <div class="card bg-transparent">
                <div class="card-body">
                    <h5 class="card-title">Pilih Nomor Cuti/Izin yang Sesuai</h5>
                    <div class="form-group row mt-4">
                        <div class="col-md-6">
                            <select class="form-control" id="idSelect" name="id_izin">
                                <option>--Pilih Nomor--</option>
                                <?php foreach ($batalkan as $batal) : ?>
                                    <?php if ($batal['history']) : ?>
                                    <?php else: ?>
                                        <option value="<?= $batal['id_izin']; ?>"
                                            data-diajukan_pada="<?= $batal['diajukan_pada']; ?>"
                                            data-nik="<?= $batal['nik']; ?>"
                                            data-inisial="<?= $batal['inisial']; ?>"
                                            data-alasan="<?= $batal['alasan_batal']; ?>"
                                            data-nama="<?= $batal['nama']; ?>"
                                            data-dept="<?= $batal['departemen']; ?>"
                                            data-izin_awal="<?= $batal['izin_awal']; ?>">
                                            <?= $batal['departemen'] . '/' . $batal['inisial'] . '/' . $batal['id_izin'] ?>/<?= $batal['alasan_izin'] == 'cuti' ? 'C' : 'I'; ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col">
                            <input type="text" name="history" value="<?= session()->get('inisial'); ?>" hidden>
                            <button type="submit" class="btn btn-primary btn-block">Setujui</button>
                        </div>
                        <div class="col">
                            <!-- <a href="/tolak-berita-acara" type="submit" class="btn btn-danger btn-block">Tolak</a> -->
                            <a href="#" type="submit" class="btn btn-danger btn-block">Tolak</a>
                        </div>
                        <div class="col mt-3">
                            <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#hisrotyModal">H i s t o r y</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card text-dark">
                <div class="card-body">
                    <h5 class="card-title">Keterangan</h5>
                    <table class="table" id="izinTable">
                        <tbody>
                            <tr>
                                <td>Diajukan Pada</td>
                                <td id="diajukanValue"></td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td id="nikValue"></td>
                            </tr>
                            <tr>
                                <td>Inisial</td>
                                <td id="inisialValue"></td>
                            </tr>
                            <tr>
                                <td>Alasan Dibatalkan</td>
                                <td id="alasanValue"></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td id="namaValue"></td>
                            </tr>
                            <tr>
                                <td>Departemen</td>
                                <td id="deptValue"></td>
                            </tr>
                            <tr>
                                <td>Tanggal Izin</td>
                                <td id="izin_awalValue"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal Structure -->
    <div class="modal fade" id="hisrotyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">History Pembatalan Cuti/Izin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Diajukan Pada</th>
                                <th scope="col">NIK</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Departemen</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Cuti/Izin</th>
                                <th scope="col">Alasan</th>
                                <th scope="col">ACC</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($batalkan as $his): ?>
                                <tr>
                                    <td><?= $his['diajukan_pada']; ?></td>
                                    <td><?= $his['nik']; ?></td>
                                    <td><?= $his['nama']; ?></td>
                                    <td><?= $his['departemen']; ?></td>
                                    <td><?= $his['izin_awal']; ?></td>
                                    <td><?= $his['alasan_izin']; ?></td>
                                    <td><?= $his['alasan_batal']; ?></td>
                                    <td><?= $his['history']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#idSelect').change(function() {
            var selectedOption = $(this).find('option:selected');

            // Ambil nilai dari data attribute
            var diajukan_pada = selectedOption.data('diajukan_pada');
            var nik = selectedOption.data('nik');
            var inisial = selectedOption.data('inisial');
            var alasan = selectedOption.data('alasan');
            var nama = selectedOption.data('nama');
            var dept = selectedOption.data('dept');
            var izin_awal = selectedOption.data('izin_awal');

            // Tampilkan nilai di tabel
            $('#diajukanValue').text(diajukan_pada);
            $('#nikValue').text(nik);
            $('#inisialValue').text(inisial);
            $('#alasanValue').text(alasan);
            $('#namaValue').text(nama);
            $('#deptValue').text(dept);
            $('#izin_awalValue').text(izin_awal);

            // Sembunyikan semua row
            $('.rowData').hide();

            // Tampilkan row yang sesuai dengan ID yang dipilih
            var selectedId = $(this).val();
            if (selectedId) {
                $('.rowData[data-id="' + selectedId + '"]').show();
            }
        });
    });
</script>
<?= $this->endSection(); ?>