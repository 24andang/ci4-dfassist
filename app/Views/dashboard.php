<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <h3>Welcome, <?= session()->get('nama') ?></h3>
                <p>Jabatan: <?= session()->get('jabatan') ?></p>
                <p>Departemen: <?= session()->get('dept') ?></p>

                <!-- Form Surat Cuti Link -->
                <a href="<?= base_url('/dashboard/form-surat-cuti') ?>" class="btn btn-primary">Tambah Surat Cuti</a>

                <!-- Logout Button -->
                <a href="<?= base_url('/logout') ?>" class="btn btn-danger mt-2">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>
