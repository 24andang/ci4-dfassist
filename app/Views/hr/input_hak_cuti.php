<?= $this->extend('\Login\layouts\layout') ?>

<?= $this->section('content') ?>
<?= $this->include('\Login\layouts\navbar') ?>

<div class="container mt-5">
    <div class="card-deck text-dark">
        <div class=" card">
            <div class="card-body">
                <h5 class="card-title">Input Cuti Karyawan</h5>
                <hr />
                <?php if (session()->getFlashdata('sukses')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('sukses'); ?>
                    </div>
                <?php elseif (session()->getFlashdata('gagal')) : ?>
                    <div class="alert alert-warning" role="alert">
                        <?= session()->getFlashdata('gagal'); ?>
                    </div>
                <?php endif; ?>
                <form action="/input_hc_all" method="post">
                    <div class="mb-3">
                        <label for="periode">Periode :</label>
                        <select name="periode" id="periode" class="form-control">
                            <option value="<?= date('Y') - 1; ?>"><?= date('Y') - 1; ?></option>
                            <option value="<?= date('Y'); ?>"><?= date('Y'); ?></option>
                            <option value="<?= date('Y') + 1; ?>"><?= date('Y') + 1; ?></option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jatah_cuti" class="form-label">Hak Cuti :</label>
                        <input type="number" class="form-control" id="jatah_cuti" maxlength="2" name="jatah_cuti">
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Hapus Periode</h5>
                <hr />
                <?php if (session()->getFlashdata('done')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('done'); ?>
                    </div>
                <?php endif; ?>
                <form action="/hapus_periode" method="post">
                    <div class="mb-3">
                        <h5> Sekarang tanggal : <?= date('d-m-Y'); ?> </h5>
                        <small><i>* Periode hangus pada tanggal 01 - 07 - <?= date('Y'); ?></i></small>
                    </div>
                    <div class="mb-3">
                        <label for="periode">Periode :</label>
                        <input type="text" value="<?= date('Y') - 1; ?>" class="form-control" readonly name="periode">
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Per NIK</h5>
                <hr />
                <?php if (session()->getFlashdata('pass')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('pass'); ?>
                    </div>
                <?php endif; ?>
                <form action="/per_nik" method="post">
                    <div class="mb-3">
                        <label for="nik">NIK :</label>
                        <input class="form-control" type="text" id="nik" name="nik" oninput="fetchUserData()">
                        <input class="form-control" type="text" id="nama" name="nama" readonly>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userDetailModal">
                            Lihat Detail
                        </button>

                    </div>
                    <div class="mb-3">
                        <label for="hak_cuti">Hak Cuti :</label>
                        <input class="form-control" type="text" name="hak_cuti" id="hak_cuti">
                    </div>
                    <div class="mb-3">
                        <label for="periode">Periode :</label>
                        <input type="text" value="<?= date('Y'); ?>" class="form-control" readonly name="periode">
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="userDetailModalLabel" style="color: black;">Detail Pengguna</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label style="color: black;">Nama :</label>
                                    <input class="form-control" type="text" id="nama1" name="nama1" readonly>
                                    <label style="color: black;">Inisial :</label>
                                    <input class="form-control" type="text" id="inisial" name="inisial" readonly>
                                    <label style="color: black;">Dept :</label>
                                    <input class="form-control" type="text" id="departemen" name="departemen" readonly>
                                    <label style="color: black;">Jabatan :</label>
                                    <input class="form-control" type="text" id="jabatan" name="jabatan" readonly>
                                    <label style="color: black;">Tanggal Join :</label>
                                    <input class="form-control" type="text" id="tgl_join" name="tgl_join" readonly>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        function fetchUserData() {
            var nik = $('#nik').val();
            if (nik.length > 0) {
                $.ajax({
                    url: "<?= site_url('user/getUserByNik') ?>",
                    type: 'POST',
                    data: {
                        nik: nik
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.error) {
                            $('#inisial').val('');
                            $('#nama').val('');
                            $('#departemen').val('');
                            $('#jabatan').val('');
                            $('#tgl_join').val('');
                        } else {
                            $('#inisial').val(data.inisial);
                            $('#nama').val(data.nama);
                            $('#nama1').val(data.nama);
                            $('#departemen').val(data.departemen);
                            $('#jabatan').val(data.jabatan);
                            $('#tgl_join').val(data.tgl_join);
                        }
                    }
                });
            }
        }
    </script>

    <?= $this->endSection() ?>