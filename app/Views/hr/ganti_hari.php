<?= $this->extend('Login/layouts/layout'); ?>
<?= $this->section('content'); ?>
<?= $this->include('Login/layouts/navbar'); ?>

<div class="row mt-5">
    <form class="col-md-4" method="post" action="/hr/input/submit_ganti_hari">
        <div class="form-group row">
            <label for="date1" class="col-sm-2 col-form-label">Dari</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" id="date1" name="date1">
                <small class="text-muted">*input tanggal (yang harusnya) libur.</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="date2" class="col-sm-2 col-form-label">Menjadi</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" id="date2" name="date2">
                <small class="text-muted">*input tanggal pengganti.</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Ganti Hari</button>
            </div>
        </div>
    </form>
    <div class="col-md-2"></div>
    <table class="table col-md-6 bg-light">
        <thead>
            <tr>
                <th scope="col" style="width: 5%;">#</th>
                <th scope="col" style="width: 30%;">Dari Tanggal</th>
                <th scope="col" style="width: 30%;">Menjadi Tanggal</th>
                <th scope="col" style="width: 35%;">Handle</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php $no = 1; ?>
                <?php foreach ($cuti_bersama as $cuber) : ?>
                    <?php if ($cuber['tanggal_awal']) : ?>

                        <th scope="row"><?= $no++; ?></th>
                        <td><?= date('d-m-Y', strtotime($cuber['tanggal_awal'])); ?></td>
                        <td><?= date('d-m-Y', strtotime($cuber['tanggal'])); ?></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?= $cuber['id']; ?>">
                                Kembalikan Semula
                            </button>
                        </td>
            </tr>

</div>

<!-- Modal Structure -->
<div class="modal fade" id="exampleModal<?= $cuber['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Kembalikan semula akan membatalkan ganti hari, yakin ?
            </div>
            <div class="modal-footer">
                <form action="/hr/input/reset_ganti_hari/<?= $cuber['id']; ?>" method="post">
                    <input type="date" name="tanggal" value="<?= $cuber['tanggal_awal']; ?>" hidden>
                    <button type="submit" class="btn btn-primary" href="">Ya</button>
                </form>
                <button type="close" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>

<script>
    document.getElementById('date1').addEventListener('input', function() {
        let inputDate = new Date(this.value);
        let day = inputDate.getUTCDay(); // 0: Minggu, 6: Sabtu

        if (day !== 0 && day !== 6) {
            // Hapus nilai jika bukan Sabtu atau Minggu
            this.value = '';
            alert('Hanya hari Sabtu dan Minggu yang bisa dipilih!');
        }
    });
</script>

<?= $this->endSection(); ?>