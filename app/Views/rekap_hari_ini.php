<?= $this->extend('Login/layouts/layout'); ?>

<?= $this->section('content'); ?>

<h2 class="mt-3">Hari / Tanggal : <?= $hari . ' / ' . date('d-m-Y'); ?></h2>

<table class="table table-stripped bg-light mt-3">
    <thead>
        <tr>
            <th scope="col">Departemen</th>
            <th scope="col">Nama Karyawan</th>
            <th scope="col">Jam</th>
            <th scope="col">Izin</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Approval</th>
            <th scope="col">Atasan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($izin_hari_ini as $izin) : ?>
            <?php if ($izin['izin_awal'] == date('Y-m-d')): ?>
                <tr>
                    <td><?= $izin['departemen']; ?></td>
                    <td><?= $izin['nama']; ?></td>
                    <td><?= $izin['sub_alasan']; ?></td>
                    <td><?= $izin['alasan_izin']; ?></td>
                    <td><?= $izin['keterangan']; ?></td>
                    <td>
                        <?= $izin['approval1'] == 1 ? '<span style="color: green; font-weight:bold">✓</span>' : '<span style="color: red; font-weight:bold">✗</span>' ?>
                        <?= $izin['approval2'] == 1 ? '<span style="color: green; font-weight:bold">✓</span>' : '<span style="color: red; font-weight:bold">✗</span>' ?>
                    </td>
                    <td><?= $izin['atasan']; ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    function autoRefresh() {
        setTimeout(function() {
            location.reload();
        }, 10000); // 300000 milliseconds = 300 seconds = 5 minutes
    }
    window.onload = autoRefresh;
</script>

<?= $this->endsection(); ?>