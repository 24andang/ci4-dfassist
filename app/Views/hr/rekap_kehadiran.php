<?= $this->extend('\Login\layouts\layout') ?>

<?= $this->section('content') ?>
<?= $this->include('\Login\layouts\navbar') ?>

<form method="get" action="">
    <div class="row">
        <div class="col-2">
            <label for="departemen">Departemen:</label>
            <select name="departemen" id="departemen" class="form-control">
                <option value="">-- Pilih Departemen --</option>
                <?php foreach ($departemen as $dept): ?>
                    <option value="<?= $dept['departemen'] ?>" <?= isset($_GET['departemen']) && $_GET['departemen'] == $dept['departemen'] ? 'selected' : '' ?>>
                        <?= $dept['departemen'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-2">
            <label for="start_date">Tanggal Awal:</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>">
        </div>
        <div class="col-2">
            <label for="end_date">Tanggal Akhir:</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>">
        </div>
        <div class="col-2 row align-items-end">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
</form>
<div class="col-2 row align-items-end">
    <button onclick="exportTableToExcel('table-id', 'rekap-kehadiran')" class="btn btn-success ml-3">Excel</button>
</div>
<form>
    </div>

    <!-- Tabel Rekap Kehadiran -->
    <?php if (!empty($kehadiran)): ?>
        <table class="table table-striped table-hover bg-light mt-3" id="table-id">
            <thead>
                <tr>
                    <th style="width: 15%;">NIK</th>
                    <th style="width: 50%;">Nama</th>
                    <th style="width: 5%;">A</th>
                    <th style="width: 5%;">I</th>
                    <th style="width: 5%;">C</th>
                    <th style="width: 5%;">S</th>
                    <th style="width: 5%;">CL</th>
                    <th style="width: 5%;">Late</th>
                    <th style="width: 5%;">PA</th>
                    <th style="width: 5%;">LK</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kehadiran as $row): ?>
                    <tr>
                        <td><input type="text" name="nik" hidden value="<?= $row['nik'] ?>"> <?= $row['nik'] ?></td>
                        <td><input type="text" name="nama" hidden value="<?= $row['nama'] ?>"><?= $row['nama'] ?></td>
                        <td>-</td>
                        <td><input type="text" name="I" hidden value="<?= $row['I'] ?>"><?= $row['I'] ?></td>
                        <td><input type="text" name="C" hidden value="<?= $row['C'] ?>"><?= $row['C']; ?></td>
                        <td><input type="text" name="S" hidden value="<?= $row['S'] ?>"><?= $row['S'] ?></td>
                        <td><input type="text" name="CL" hidden value="<?= $row['CL'] ?>"><?= $row['CL'] ?></td>
                        <td><input type="text" name="Late" hidden value="<?= $row['Late'] ?>"><?= $row['Late'] ?></td>
                        <td><input type="text" name="PA" hidden value="<?= $row['PA'] ?>"><?= $row['PA']; ?></td>
                        <td><input type="text" name="LK" hidden value="<?= $row['LK'] ?>"><?= $row['LK']; ?></td>
                    </tr>
                <?php endforeach; ?>
</form>
</tbody>
</table>
<?php else: ?>
    <p>Tidak ada data yang tersedia berdasarkan filter yang diterapkan.</p>
<?php endif; ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script>
    function exportTableToExcel(tableId, filename = 'data') {
        // Ambil tabel HTML berdasarkan ID
        const table = document.getElementById(tableId);
        const wb = XLSX.utils.table_to_book(table, {
            sheet: "Sheet1"
        });

        // Buat file Excel
        XLSX.writeFile(wb, `${filename}.xlsx`);
    }
</script>


<?= $this->endsection() ?>