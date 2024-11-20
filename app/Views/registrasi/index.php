<?= $this->extend('Login\layouts\layout') ?>


<?= $this->section('content') ?>
<?= $this->include('Login\layouts\navbar') ?>


<h2>Registrasi List</h2>
<?php if (session()->getFlashdata('message')) : ?>
  <div class="alert alert-success">
    <?= session()->getFlashdata('message') ?>
  </div>
<?php endif; ?>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal" <?= session()->get('inisial') == 'DKA' ? '' : 'disabled'; ?>>
  Tambah Data
</button>
<a href="/prog-maklon" class="btn btn-primary">Progress</a>
<!-- <a href="/logout" class="btn btn-danger mb-3">Logout</a> -->
<table class="table bg-light opacity-75">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal MOU</th>
      <th>Nomor Surat</th>
      <th>Nama Perusahaan</th>
      <th>User</th>
      <th>Merk</th>
      <th>Akhir Kontrak</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1;
    foreach ($registrasi as $reg) : ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $reg['tanggal_mou'] ?></td>
        <td><?= $reg['nomor_surat'] ?></td>
        <td><?= $reg['nama_perusahaan'] ?></td>
        <td><?= $reg['user'] ?></td>
        <td><?= $reg['merk'] ?></td>
        <td><?= $reg['akhir_kontrak'] ?></td>
        <td>
          <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $reg['id'] ?>" <?= session()->get('inisial') == 'DKA' ? '' : 'disabled'; ?>>
            Edit
          </button>
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?= $reg['id'] ?>" <?= session()->get('inisial') == 'DKA' ? '' : 'disabled'; ?>>
            Hapus
          </button>
        </td>
      </tr>

      <!-- Edit Modal -->
      <div class="modal fade" id="editModal<?= $reg['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $reg['id'] ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content  bg-dark">
            <div class="modal-header">
              <h5 class="modal-title" id="editModalLabel<?= $reg['id'] ?>">Edit Data Registrasi</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="/registrasi/update/<?= $reg['id'] ?>" method="post">
              <?= csrf_field() ?>
              <div class="modal-body">
                <div class="form-group">
                  <label for="tanggal_mou">Tanggal MOU</label>
                  <input type="date" class="form-control" id="tanggal_mou" name="tanggal_mou" value="<?= $reg['tanggal_mou'] ?>" required>
                </div>
                <div class="form-group">
                  <label for="nomor_surat">Nomor Surat</label>
                  <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" value="<?= $reg['nomor_surat'] ?>" required>
                </div>
                <div class="form-group">
                  <label for="nama_perusahaan">Nama Perusahaan</label>
                  <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" value="<?= $reg['nama_perusahaan'] ?>" required>
                </div>
                <div class="form-group">
                  <label for="user">User</label>
                  <input type="text" class="form-control" id="user" name="user" value="<?= $reg['user'] ?>" required>
                </div>
                <div class="form-group">
                  <label for="merk">Merk</label>
                  <input type="text" class="form-control" id="merk" name="merk" value="<?= $reg['merk'] ?>" required>
                </div>
                <div class="form-group">
                  <label for="akhir_kontrak">Akhir Kontrak</label>
                  <input type="date" class="form-control" id="akhir_kontrak" name="akhir_kontrak" value="<?= $reg['akhir_kontrak'] ?>" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Delete Modal -->
      <div class="modal fade" id="deleteModal<?= $reg['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?= $reg['id'] ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content bg-dark">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel<?= $reg['id'] ?>">Hapus Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="/registrasi/delete/<?= $reg['id'] ?>" method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="_method" value="DELETE">
              <div class="modal-body">
                <p>WARNING!!!</p>
                <p> Menghapus data ini akan menghapus juga data yang berkaitan pada halaman "Progress"</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    <?php endforeach; ?>
  </tbody>
</table>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-dark">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Tambah Data Registrasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/registrasi/create" method="post">
        <?= csrf_field() ?>
        <div class="modal-body">
          <div class="form-group">
            <label for="tanggal_mou">Tanggal MOU</label>
            <input type="date" class="form-control" id="tanggal_mou" name="tanggal_mou" required>
          </div>
          <div class="form-group">
            <label for="nomor_surat">Nomor Surat</label>
            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" required>
          </div>
          <div class="form-group">
            <label for="nama_perusahaan">Nama Perusahaan</label>
            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" required>
          </div>
          <div class="form-group">
            <label for="user">User</label>
            <input type="text" class="form-control" id="user" name="user" required>
          </div>
          <div class="form-group">
            <label for="merk">Merk</label>
            <input type="text" class="form-control" id="merk" name="merk" required>
          </div>
          <div class="form-group">
            <label for="akhir_kontrak">Akhir Kontrak</label>
            <input type="date" class="form-control" id="akhir_kontrak" name="akhir_kontrak" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>