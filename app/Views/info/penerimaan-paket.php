<?= $this->extend('\layouts\layout\main') ?>

<?= $this->section('content') ?>
<?= $this->include('\layouts\layout\navbar') ?>

<h3 class="my-3">Penerimaan Paket / Barang</h3>

<?php if (session()->getFlashdata('diambil')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('diambil'); ?>
    </div>
<?php endif; ?>

<table class="table table-light">
    <thead>
        <tr>
            <th scope="col" style="width: 5%;">#</th>
            <th scope="col" style="width: 15%;">Kepada</th>
            <th scope="col" style="width: 10%;">Ekspedisi</th>
            <th scope="col" style="width: 20%;">Pengirim</th>
            <th scope="col" style="width: 20%;">No Resi</th>
            <th scope="col" style="width: 10%;">Tanggal Datang</th>
            <th scope="col" style="width: 10%;">Petugas</th>
            <th scope="col" style="width: 10%;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($logs as $log): ?>
            <tr>
                <th scope="row"><?= $no++; ?></th>
                <td><?= $log['penerima']; ?></td>
                <td><?= $log['ekspedisi']; ?></td>
                <td><?= $log['nama']; ?></td>
                <td><?= $log['no_resi']; ?></td>
                <td><?= $log['tanggal']; ?></td>
                <td><?= $log['petugas']; ?></td>
                <td>
                    <div class="btn btn-info" data-toggle="modal" data-target="#modal<?= $log['id']; ?>">Ambil</div>
                </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="modal<?= $log['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content text-dark">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ambil Paket / Barang</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?= $log['keterangan']; ?> untuk <?= $log['penerima']; ?> ?
                        </div>
                        <div class="modal-footer">
                            <form action="/info/pengambilan-paket" method="post">
                                <input type="text" value="<?= $log['id']; ?>" hidden name="id">
                                <input type="text" value="<?= session()->get('inisial'); ?>" hidden name="inisial">
                                <input type="text" value="<?= session()->get('departemen'); ?>" hidden name="departemen">
                                <button type="submit" class="btn btn-primary">Ya</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </tbody>
</table>


<?= $this->endSection(); ?>