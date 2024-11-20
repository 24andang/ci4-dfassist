<?= $this->extend('\layouts\layout\main') ?>

<?= $this->section('content') ?>
<?= $this->include('\layouts\layout\navbar') ?>

<h3 class="my-3">History</h3>

<form action="/info/history-paket" method="get">
    <div class="row">
        <div class="col-4">
            <label for="category">Kategori</label>
            <select class="form-select" id="category" name="category">
                <option value="paket" <?= $category == 'paket' ? 'selected' : ''; ?>>Paket</option>
                <option value="tamu" <?= $category == 'tamu' ? 'selected' : ''; ?>>Tamu</option>
                <option value="bahan" <?= $category == 'bahan' ? 'selected' : ''; ?>>Bahan Baku</option>
            </select>
        </div>
        <div class="col-3">
            <label for="date1">Dari</label>
            <input class="form-control" type="date" name="date1" id="date1">
        </div>
        <div class="col-3">
            <label for="date2">Sampai</label>
            <span class="bg-danger text-white ml-5 fst-italic" id="span-date2" style="display: none;">Tanggal tidak valid.</span>
            <input class="form-control" type="date" name="date2" id="date2">
        </div>
        <div class="col row align-items-end mr-2">
            <button type="submit" class="btn btn-info">Filter</button>
        </div>
</form>

<?php if (!empty($logs)): ?>
    <table class="table table-light mt-3">
        <thead>
            <tr>
                <th scope="col" style="width: 5%;">#</th>
                <th scope="col">Kepada</th>
                <th scope="col">Paket / Barang</th>
                <th scope="col">Pengirim</th>
                <th scope="col">Asal / Instansi</th>
                <th scope="col">Diambil Oleh</th>
                <th scope="col">Diambil Tanggal</th>
                <th scope="col">Petugas</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><?= $log['penerima']; ?></td>
                    <td><?= $log['keterangan']; ?></td>
                    <td><?= $log['nama']; ?></td>
                    <td><?= $log['instansi']; ?></td>
                    <td><?= $log['pengambil']; ?></td>
                    <td><?= $log['keluar']; ?></td>
                    <td><?= $log['petugas']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Data Empty.</p>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const date1 = document.getElementById('date1');
        const date2 = document.getElementById('date2');
        const spanDate2 = document.getElementById('span-date2');

        date2.disabled = true;

        date1.addEventListener('change', function() {
            date2.disabled = false;
            date2.value = date1.value;
        });

        date2.addEventListener('change', function() {
            if (date2.value < date1.value) {
                spanDate2.style.display = 'inline';
                date2.value = '';
            }
        });
    });
</script>
<?= $this->endSection(); ?>