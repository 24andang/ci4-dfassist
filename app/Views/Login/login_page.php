<?= $this->extend('\Login\layouts\layout') ?>

<?= $this->section('content') ?>
<div class="background-animation">
    <?php for ($i = 0; $i < 30; $i++) : ?>
        <div class="circle" style="width: <?= rand(20, 100); ?>px; height: <?= rand(20, 100); ?>px; top: <?= rand(-100, 100); ?>%; left: <?= rand(-100, 100); ?>%; animation-delay: <?= rand(0, 10); ?>s;"></div>
    <?php endfor; ?>
</div>
<div class="container-fluid d-flex justify-content-center align-items-center full-height">
    <div class="card" style="width: 18rem;">
        <div class="card-header bg-dark">Log In</div>
        <div class="card-body text-secondary">
            <form action="/login" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="inisial" class="form-label">Inisial</label>
                    <input type="text" class="form-control" id="inisial" name="inisial" maxlength="3">
                </div>
                <div class="mb-3">
                    <label for="pass" class="form-label">Password</label>
                    <input type="password" class="form-control" id="pass" name="pass">
                </div>

                <?php if (session()->getFlashdata('msg')) : ?>
                    <div class="alert alert-info" role="alert">
                        <div><?= session()->getFlashdata('msg') ?></div>
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <a class="nav-link" data-bs-toggle="dropdown" role="button">Lupa password ?</a>
        <ul class="dropdown-menu">
            <li class="p-2 bg-info text-dark bg-opacity-25"> Hubungi tim IT, ext. 229. </li>
        </ul>
        <?php
        // Dapatkan alamat IP pengguna
        $ip_address = $_SERVER['REMOTE_ADDR'];

        $allowed_ips = ['192.168.200.253', '192.168.200.27'];

        // Tentukan apakah IP-nya sesuai dengan yang diinginkan
        if (in_array($ip_address, $allowed_ips)): ?>
            <a type="submit" href="/daftar-izin" class="btn btn-warning">Karyawan Izin</a>
        <?php endif; ?>
        <!-- <a type="submit" href="/daftar-izin" class="btn btn-warning">Karyawan Izin</a> -->
        <!-- <a href="karyawan-izin" class="btn btn-primary">Karyawan Izin</a> -->
    </div>
</div>


<?= $this->endSection() ?>