<?= $this->extend('login/layouts/layout'); ?>

<?= $this->section('content'); ?>
<?= $this->include('login/layouts/navbar'); ?>

<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('message') ?>
    </div>
<?php endif; ?>
<button type="button" class="btn btn-primary mt-3 mb-3" data-toggle="modal" data-target="#addModal">
    Tambah Data
</button>

<div class="table-responsive" style="max-height: 80vh;">
    <table class="table bg-light opacity-75 mt-3">
        <thead style="position: sticky; top: 0; background-color: #fff;">
            <tr>
                <th>No</th>
                <th>Inisial</th>
                <th>Nama</th>
                <th>Dept</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($user as $u) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $u['inisial'] ?></td>
                    <td><?= $u['nama'] ?></td>
                    <td><?= $u['departemen'] ?></td>
                    <td>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $u['id'] ?>">
                            Edit
                        </button>
                        <a href="/admin/delete/<?= $u['id'] ?>" class="btn btn-danger" onclick="confirm('Hapus data user')">Delete</a>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal<?= $u['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $u['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content  bg-dark">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel<?= $u['id'] ?>">Edit Data User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/admin/update/<?= $u['id'] ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="inisial">Inisial</label>
                                        <input type="text" class="form-control" id="inisial" name="inisial" value="<?= $u['inisial'] ?>" required maxlength="3">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $u['nama'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="dept">Dept</label>
                                        <input type="text" class="form-control" id="departemen" name="departemen" value="<?= $u['departemen'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="jabatan">Jabatan</label>
                                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= $u['jabatan'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pass">Pass</label>
                                        <input type="password" class="form-control" id="pass" name="pass" value="<?= $u['pass'] ?>" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/create" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="number" class="form-control" id="nik" name="nik" required>
                    </div>
                    <div class="form-group">
                        <label for="inisial">Inisial</label>
                        <input type="text" class="form-control" id="inisial" name="inisial" maxlength="3" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="departemen">Departemen</label>
                        <select name="departemen" id="departemen" class="form-select">
                            <?php foreach ($departemen as $dept) : ?>
                                <option value="<?= $dept['departemen']; ?>"><?= $dept['departemen']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <select name="jabatan" id="jabatan" class="form-select">
                            <?php foreach ($jabatan as $jab) : ?>
                                <option value="<?= $jab['jabatan']; ?>"><?= $jab['jabatan']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tgl_join">Tanggal Join :</label>
                        <input type="date" name="tgl_join" id="tgl_join" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="pass">Pass</label>
                        <input type="password" class="form-control" id="pass" name="pass" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
            </form>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>