<?= $this->extend('\layouts\layout\main') ?>

<?= $this->section('content') ?>
<?= $this->include('\layouts\layout\navbar') ?>

<h1>Info Kehadiran Dept</h1>
<form action="/info/kehadiran" method="get">
    <div class="row">
        <div class="col-3">
            <label for="alasan">Alasan</label>
            <select class="form-select" id="alasan" name="alasan">
                <option value="cuti" <?= $alasan == 'cuti' ? 'selected' : ''; ?>>Cuti</option>
                <option value="pulang lebih awal" <?= $alasan == 'pulang lebih awal' ? 'selected' : ''; ?>>Pulang Lebih Awal</option>
                <option value="datang terlambat" <?= $alasan == 'datang terlambat' ? 'selected' : ''; ?>>Datang Terlambat</option>
                <option value="meninggalkan kantor" <?= $alasan == 'meninggalkan kantor' ? 'selected' : ''; ?>>Meninggalkan Kantor</option>
                <option value="sakit" <?= $alasan == 'sakit' ? 'selected' : ''; ?>>Sakit</option>
                <option value="luar kota" <?= $alasan == 'luar kota' ? 'selected' : ''; ?>>Luar Kota</option>
                <option value="tidak hadir" <?= $alasan == 'tidak hadir' ? 'selected' : ''; ?>>Tidak Hadir</option>
                <option value="izin lain-lain" <?= $alasan == 'izin lain-lain' ? 'selected' : ''; ?>>Lain-lain</option>
            </select>
        </div>
        <div class="col-2">
            <label for="date1">Dari</label>
            <input class="form-control" type="date" name="date1" id="date1">
        </div>
        <div class="col-2">
            <label for="date2">Sampai</label>
            <span class="bg-danger text-white ml-5 fst-italic" id="span-date2" style="display: none;">Tanggal tidak valid.</span>
            <input class="form-control" type="date" name="date2" id="date2">
        </div>
        <div class="col row align-items-end mr-2">
            <button type="submit" class="btn btn-info">Filter</button>
        </div>
</form>
<div class="col row align-items-end">
    <button onclick="exportTableToExcel('table-id', 'izin_data')" class="btn btn-success">Excel</button>
</div>
</div>

<?php if (!empty($izin)): ?>

    <table class="table bg-light mt-3" id="table-id">
        <thead>
            <tr>
                <th scope="col" style="width: 5%;">#</th>
                <th scope="col" style="width: 10%;">Tanggal</th>
                <th scope="col" style="width: 15%;">NIK</th>
                <th scope="col" style="width: 25%;">Nama</th>
                <th scope="col" style="width: 25%;">Keterangan</th>
                <th scope="col" style="width: 10%;"></th>
                <th scope="col" style="width: 10%;">Approval</th>
            </tr>
        </thead>
        <tbody id="table-body">
        </tbody>
    </table>

<?php else: ?>
    <p>Data Empty.</p>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // DOM
        const date1 = document.getElementById('date1');
        const date2 = document.getElementById('date2');
        const spanDate2 = document.getElementById('span-date2');
        const tBody = document.getElementById('table-body');

        // db
        const izinDB = <?= $izin ? json_encode($izin) : 'db not found' ?>;

        function addDays(date, days) {
            const result = new Date(date);
            result.setDate(result.getDate() + days);
            return result;
        }

        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        let no = 1;
        izinDB.forEach(item => {
            const startDate = new Date(item.izin_awal);
            const endDate = new Date(item.izin_akhir);

            for (let d = startDate; d <= endDate; d = addDays(d, 1)) {
                const tr = document.createElement('tr');

                const tdNo = document.createElement('td');
                tdNo.innerText = no++;

                const tdTgl = document.createElement('td');
                tdTgl.innerText = formatDate(d);

                const tdNIK = document.createElement('td');
                tdNIK.innerText = item.nik;

                const tdNama = document.createElement('td');
                tdNama.innerText = item.nama;

                const tdKet = document.createElement('td');
                tdKet.innerText = item.keterangan;

                const tdSubAlasan = document.createElement('td');
                tdSubAlasan.innerText = item.sub_alasan;

                const tdApp1 = document.createElement('td');
                tdApp1.innerText = item.atasan;

                // Tambahkan <td> ke <tr>
                tr.appendChild(tdNo);
                tr.appendChild(tdTgl);
                tr.appendChild(tdNIK);
                tr.appendChild(tdNama);
                tr.appendChild(tdKet);
                tr.appendChild(tdSubAlasan);
                tr.appendChild(tdApp1);

                // Tambahkan <tr> ke <tbody>
                tBody.appendChild(tr);
            }
        });

        // display
        date1.addEventListener('change', function() {
            if (date1.value) {
                date2.disabled = false;
            } else {
                date2.disabled = true;
                date2.value = '';
            }
        });

        date2.addEventListener('change', function() {
            if (date2.value < date1.value) {
                spanDate2.style.display = 'inline';
                date2.value = '';
            } else {
                spanDate2.style.display = 'none';
            };
        });
    });

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

<?= $this->endSection(); ?>