<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h2>Add New Progress</h2>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
    Add New
</button>

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add New Progress</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/progress/store" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="registrasi_id">Merk dan Nama Perusahaan</label>
                        <select class="form-control" name="registrasi_id">
                            <?php foreach ($registrasi as $reg): ?>
                            <option value="<?= $reg['id'] ?>"><?= $reg['merk'] ?> - <?= $reg['nama_perusahaan'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dp">DP</label>
                        <input type="checkbox" name="dp" value="1">
                    </div>
                    <div class="form-group">
                        <label for="rmpm">RMPM</label>
                        <input type="checkbox" name="rmpm" value="1">
                    </div>
                    <div class="form-group">
                        <label for="desain_mockup">Desain Mockup</label>
                        <input type="checkbox" name="desain_mockup" value="1">
                    </div>
                    <div class="form-group">
                        <label for="produksi">Produksi</label>
                        <input type="checkbox" name="produksi" value="1">
                    </div>
                    <div class="form-group">
                        <label for="surat_jalan">Surat Jalan</label>
                        <input type="checkbox" name="surat_jalan" value="1">
                    </div>
                    <div class="form-group">
                        <label for="pelunasan">Pelunasan</label>
                        <input type="checkbox" name="pelunasan" value="1">
                    </div>
                    <div class="form-group">
                        <label for="pengiriman">Pengiriman</label>
                        <input type="checkbox" name="pengiriman" value="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
