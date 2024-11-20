<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h2>Edit Progress</h2>
<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal">
    Edit
</button>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Progress</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/progress/update/<?= $progress['id'] ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="registrasi_id">Merk dan Nama Perusahaan</label>
                        <select class="form-control" name="registrasi_id">
                            <?php foreach ($registrasi as $reg): ?>
                            <option value="<?= $reg['id'] ?>" <?= $reg['id'] == $progress['registrasi_id'] ? 'selected' : '' ?>><?= $reg['merk'] ?> - <?= $reg['nama_perusahaan'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dp">DP</label>
                        <input type="checkbox" name="dp" value="1" <?= $progress['dp'] ? 'checked' : '' ?>>
                    </div>
                    <div class="form-group">
                        <label for="rmpm">RMPM</label>
                        <input type="checkbox" name="rmpm" value="1" <?= $progress['rmpm'] ? 'checked' : '' ?>>
                    </div>
                    <div class="form-group">
                        <label for="desain_mockup">Desain Mockup</label>
                        <input type="checkbox" name="desain_mockup" value="1" <?= $progress['desain_mockup'] ? 'checked' : '' ?>>
                    </div>
                    <div class="form-group">
                        <label for="produksi">Produksi</label>
                        <input type="checkbox" name="produksi" value="1" <?= $progress['produksi'] ? 'checked' : '' ?>>
                    </div>
                    <div class="form-group">
                        <label for="surat_jalan">Surat Jalan</label>
                        <input type="checkbox" name="surat_jalan" value="1" <?= $progress['surat_jalan'] ? 'checked' : '' ?>>
                    </div>
                    <div class="form-group">
                        <label for="pelunasan">Pelunasan</label>
                        <input type="checkbox" name="pelunasan" value="1" <?= $progress['pelunasan'] ? 'checked' : '' ?>>
                    </div>
                    <div class="form-group">
                        <label for="pengiriman">Pengiriman</label>
                        <input type="checkbox" name="pengiriman" value="1" <?= $progress['pengiriman'] ? 'checked' : '' ?>>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
