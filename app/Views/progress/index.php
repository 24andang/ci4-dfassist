<?= $this->extend('Login\layouts\layout') ?>

<?= $this->section('content') ?>
<?= $this->include('Login\layouts\navbar') ?>

<h2>Progress List</h2>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah" <?= session()->get('inisial') == 'DKA' ? '' : 'disabled'; ?>>Tambah Data</button>
<a href="/reg-maklon" class="btn btn-primary">Registrasi</a>
<table class="table bg-light opacity-75">
    <thead>
        <tr>
            <th>No</th>
            <th>Merk</th>
            <th>Nama Perusahaan</th>
            <th>DP</th>
            <th>RMPM</th>
            <th>Desain Mockup</th>
            <th>Produksi</th>
            <th>Surat Jalan</th>
            <th>Pelunasan</th>
            <th>Pengiriman</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($progress as $index => $row): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $row['merk'] ?></td>
                <td><?= $row['nama_perusahaan'] ?></td>
                <td><?= $row['dp'] ? '✓' : '✗' ?></td>
                <td><?= $row['rmpm'] ? '✓' : '✗' ?></td>
                <td><?= $row['desain_mockup'] ? '✓' : '✗' ?></td>
                <td><?= $row['produksi'] ? '✓' : '✗' ?></td>
                <td><?= $row['surat_jalan'] ? '✓' : '✗' ?></td>
                <td><?= $row['pelunasan'] ? '✓' : '✗' ?></td>
                <td><?= $row['pengiriman'] ? '✓' : '✗' ?></td>
                <td>
                    <button type="button" class="btn btn-warning btn-edit" data-id="<?= $row['id'] ?>" data-merk="<?= $row['merk'] ?>" data-nama_perusahaan="<?= $row['nama_perusahaan'] ?>" data-dp="<?= $row['dp'] ?>" data-rmpm="<?= $row['rmpm'] ?>" data-desain_mockup="<?= $row['desain_mockup'] ?>" data-produksi="<?= $row['produksi'] ?>" data-surat_jalan="<?= $row['surat_jalan'] ?>" data-pelunasan="<?= $row['pelunasan'] ?>" data-pengiriman="<?= $row['pengiriman'] ?>" <?= session()->get('inisial') == 'GRR' ? '' : 'disabled'; ?>>Edit</button>
                    <button type="button" class="btn btn-danger btn-delete" data-id="<?= $row['id'] ?>" data-merk="<?= $row['merk'] ?>" data-nama_perusahaan="<?= $row['nama_perusahaan'] ?>" <?= session()->get('inisial') == 'DKA' ? '' : 'disabled'; ?>>Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal Tambah Data -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahTitle">Tambah Data Progress</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/progress/store" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="registrasi_id">Merk - Nama Perusahaan</label>
                        <select class="form-control" name="registrasi_id">
                            <?php if (!empty($registrasi)): ?>
                                <?php foreach ($registrasi as $reg): ?>
                                    <option value="<?= $reg['id'] ?>"><?= $reg['merk'] ?> - <?= $reg['nama_perusahaan'] ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">Tidak ada data registrasi</option>
                            <?php endif; ?>
                        </select>
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

<!-- Modal Edit Data -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditTitle">Pilih Progress</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <form id="formEdit" action="" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_dp">DP</label>
                        <input type="checkbox" name="dp" value="1" id="edit_dp">
                    </div>
                    <div class="form-group">
                        <label for="edit_rmpm">RMPM</label>
                        <input type="checkbox" name="rmpm" value="1" id="edit_rmpm">
                    </div>
                    <div class="form-group">
                        <label for="edit_desain_mockup">Desain Mockup</label>
                        <input type="checkbox" name="desain_mockup" value="1" id="edit_desain_mockup">
                    </div>
                    <div class="form-group">
                        <label for="edit_produksi">Produksi</label>
                        <input type="checkbox" name="produksi" value="1" id="edit_produksi" <?= session()->get('dept') == 'prod' ? ' ' : 'disabled' ?>>
                    </div>
                    <div class="form-group">
                        <label for="edit_surat_jalan">Surat Jalan</label>
                        <input type="checkbox" name="surat_jalan" value="1" id="edit_surat_jalan">
                    </div>
                    <div class="form-group">
                        <label for="edit_pelunasan">Pelunasan</label>
                        <input type="checkbox" name="pelunasan" value="1" id="edit_pelunasan">
                    </div>
                    <div class="form-group">
                        <label for="edit_pengiriman">Pengiriman</label>
                        <input type="checkbox" name="pengiriman" value="1" id="edit_pengiriman">
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus Data -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteTitle">Hapus Data Progress</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <form id="formDelete" action="" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" id="deleteId" name="id">
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data progress ini?</p>
                    <p id="deleteInfo"></p>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        // Event listener for the edit buttons
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', (event) => {
                const button = event.currentTarget;
                const id = button.getAttribute('data-id');
                const merk = button.getAttribute('data-merk');
                const nama_perusahaan = button.getAttribute('data-nama_perusahaan');
                const dp = button.getAttribute('data-dp');
                const rmpm = button.getAttribute('data-rmpm');
                const desain_mockup = button.getAttribute('data-desain_mockup');
                const produksi = button.getAttribute('data-produksi');
                const surat_jalan = button.getAttribute('data-surat_jalan');
                const pelunasan = button.getAttribute('data-pelunasan');
                const pengiriman = button.getAttribute('data-pengiriman');

                // Fill the form with existing data
                document.querySelector('#formEdit').setAttribute('action', `/progress/update/${id}`);
                document.querySelector('#edit_dp').checked = dp === '1';
                document.querySelector('#edit_rmpm').checked = rmpm === '1';
                document.querySelector('#edit_desain_mockup').checked = desain_mockup === '1';
                document.querySelector('#edit_produksi').checked = produksi === '1';
                document.querySelector('#edit_surat_jalan').checked = surat_jalan === '1';
                document.querySelector('#edit_pelunasan').checked = pelunasan === '1';
                document.querySelector('#edit_pengiriman').checked = pengiriman === '1';

                // Open the modal
                $('#modalEdit').modal('show');
            });
        });

        /// Event listener for the delete buttons
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', (event) => {
                const button = event.currentTarget;
                const id = button.getAttribute('data-id');
                const merk = button.getAttribute('data-merk');
                const nama_perusahaan = button.getAttribute('data-nama_perusahaan');

                // Set the form action and delete info
                document.querySelector('#formDelete').setAttribute('action', `/progress/delete/${id}`);
                document.querySelector('#deleteId').value = id;
                document.querySelector('#deleteInfo').textContent = `Merk: ${merk}, Nama Perusahaan: ${nama_perusahaan}`;

                // Open the modal
                $('#modalDelete').modal('show');
            });
        });
        xml_error_string
    });
</script>

<?= $this->endSection() ?>