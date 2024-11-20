<?= $this->extend('\Login\layouts\layout') ?>

<?= $this->section('content') ?>
<?= $this->include('\Login\layouts\navbar') ?>

<form class="mt-3" method="post" action="/hr/cuti/input_cuti_bersama">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="Keterangan">Keterangan</label>
            <input type="Keterangan" class="form-control" name="keterangan" id="Keterangan">
        </div>
        <div class="form-group col-md-2">
            <label for="cuber">Cuti Bersama</label> <br />
            <input type="checkbox" class="form-check-input ml-5" name="cuber" id="cuber" value="Cuti Bersama">
        </div>
        <div class="form-group col-md-4">
            <label for="Tanggal">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" id="Tanggal" required>
        </div>
        <div class="form-group col-md-2">
            <button type="submit" class="btn btn-primary" style="margin-top: 18%;">Submit</button>
        </div>
    </div>
</form>

<table class="table bg-light mt-5">
    <thead>
        <tr>
            <th scope="col" style="width: 5%;">#</th>
            <th scope="col" style="width: 50%;">Keterangan</th>
            <th scope="col" style="width: 30%;">Tanggal</th>
            <th scope="col" style="width: 15%;">Hapus</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($cuti_bersama as $cuber) : ?>
            <tr>
                <td scope="row"><?= $no; ?></td>
                <td><?= $cuber['keterangan']; ?></td>
                <td><?= date('d-m-Y', strtotime($cuber['tanggal'])); ?></td>
                <td>
                    <a class="btn btn-warning" data-toggle="modal" data-target="#hapusModal">Hapus</a>
                </td>
            </tr>


            <!-- Hapus Modal -->
            <div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content text-dark">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <h5 class="modal-title" id="hapusModalLabel">Hapus data cuti bersama ?</h5>
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <a href="/hr/cuti/hapus_cuti_bersama/<?= $cuber['id']; ?>" class="btn btn-danger">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection(); ?>