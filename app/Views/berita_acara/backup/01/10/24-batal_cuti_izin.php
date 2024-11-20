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
                    <hr />
                    <div class="form-group row">
                        <div class="col-md-6">
                            <select class="form-control" id="idSelect" name="id_izin">
                                <option>--Pilih Nomor--</option>
                                <?php foreach ($batalkan as $batal) : ?>
                                    <?php if ($batal['history']) : ?>
                                    <?php else: ?>
                                        <option value="<?= $batal['id_izin']; ?>">
                                            <?= $batal['departemen'] . '/' . $batal['inisial'] . '/' . $batal['id_izin'] ?>/<?= $batal['alasan_izin'] == 'cuti' ? 'C' : 'I'; ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Setujui</button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#hisrotyModal">History</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card text-dark">
                <div class="card-body">
                    <h5 class="card-title">Keterangan</h5>
                    <table class="table" id="izinTable">
                        <tbody>
                            <?php foreach ($batalkan as $row): ?>
                                <tr class="rowData" data-id="<?= $row['id_izin']; ?>" style="display: none;">
                                    <td>NIK</td>
                                    <td><?= $row['nik']; ?></td>
                                </tr>
                                <tr class="rowData" data-id="<?= $row['id_izin']; ?>" style="display: none;">
                                    <td>Nama</td>
                                    <td><?= $row['nama']; ?></td>
                                </tr>
                                <tr class="rowData" data-id="<?= $row['id_izin']; ?>" style="display: none;">
                                    <td>Tanggal</td>
                                    <td><?= $row['izin_awal']; ?></td>
                                </tr>
                                <tr class="rowData" data-id="<?= $row['id_izin']; ?>" style="display: none;">
                                    <td>Cuti/Izin</td>
                                    <td><?= $row['alasan_izin']; ?></td>
                                </tr>
                                <tr class="rowData" data-id="<?= $row['id_izin']; ?>" style="display: none;">
                                    <td>Alasan dibatalkan</td>
                                    <td><?= $row['alasan_batal']; ?></td>
                                </tr>
                                <tr class="rowData" data-id="<?= $row['id_izin']; ?>" style="display: none;">
                                    <td>Total cuti</td>
                                    <td><?= $row['total_cuti']; ?></td>
                                </tr>
                                <tr class="rowData" data-id="<?= $row['id_izin']; ?>" style="display: none;">
                                    <td>Periode</td>
                                    <td><?= $row['periode_cuti']; ?></td>
                                </tr>
                                <input type="text" name="id_batal" value="<?= $row['id_batal']; ?>" hidden>
                                <input type="text" name="inisial_hr" value="<?= session()->get('inisial'); ?>" hidden>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
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
            var selectedId = $(this).val();

            // Sembunyikan semua row
            $('.rowData').hide();

            // Tampilkan row yang sesuai dengan ID yang dipilih
            if (selectedId) {
                $('.rowData[data-id="' + selectedId + '"]').show();
            }
        });
    });
</script>
<?= $this->endSection(); ?>