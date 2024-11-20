<?= $this->extend('\Login\layouts\layout') ?>

<?= $this->section('content') ?>
<?= $this->include('\Login\layouts\navbar') ?>

<div class="mt-3 text-dark">
    <div class="card border-secondary mb-3" style="max-width: 18rem;">
        <div class="card-header">Ganti Password</div>
        <div class="card-body text-secondary">
            <h5 class="card-title"><?= $user['nama']; ?> (<?= $user['inisial']; ?>)</h5>
            <form action="/simpanpass/<?= $user['id']; ?>" method="post">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="pass" class="col-form-label">Password baru</label>
                    </div>
                    <div class="col-auto">
                        <input type="password" id="pass" class="form-control" name="pass">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-outline-primary">Submit</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>