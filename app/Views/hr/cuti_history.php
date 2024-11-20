<?= $this->extend('\Login\layouts\layout') ?>

<?= $this->section('content') ?>
<?= $this->include('\Login\layouts\navbar') ?>

<div class="d-flex justify-content-between align-items-center">
    <h1>History Cuti</h1>
    <div>
        <span class="me-2"><span style="color: orchid; font-weight:bold">?</span>= Menunggu</span>
        <span class="me-2"><span style="color: green; font-weight:bold">✓</span>= Disetujui</span>
        <span><span style="color: red; font-weight:bold">✗</span>= Ditolak</span>
    </div>
</div>



<?php if (session()->getFlashdata('pass')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('pass') ?>
    </div>
<?php elseif (session()->getFlashdata('block')) : ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('block') ?>
    </div>
<?php endif; ?>

<table class="table bg-light">
    <thead>
        <tr>
            <th style="width : 20%">Nomor Izin</th>
            <th style="width : 35%">Alasan Cuti</th>
            <th style="width : 10%">Tanggal</th>
            <th style="width : 10%">Approval</th>
            <th style="width : 10%">Cetak</th>
            <th style="width : 15%">Batal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($surat_izin as $cuti): ?>
            <tr>
                <td><?= $cuti['departemen'] . '/' . $cuti['inisial'] . '/' . $cuti['id_izin'] . '/C'; ?></td>
                <td style=""><?= $cuti['keterangan']; ?></td>
                <td><?= date('d-m-Y', strtotime($cuti['izin_awal'])); ?></td>
                <td>
                    <?= $cuti['approval1'] == 1 ? '<span style="color: green; font-weight:bold">✓</span>' : ($cuti['approval1'] == 9 ? '<span style="color: red; font-weight:bold">✗</span>' : '<span style="color: orchid; font-weight:bold">?</span>'); ?>
                    <?= $cuti['approval2'] == 1 ? '<span style="color: green; font-weight:bold">✓</span>' : ($cuti['approval2'] == 9 ? '<span style="color: red; font-weight:bold">✗</span>' : '<span style="color: orchid; font-weight:bold">?</span>'); ?>
                </td>
                <td>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editModal<?= $cuti['id_izin'] ?>">
                        Kartu
                    </button>
                </td>
                <?php if ($cuti['approval1'] == 0): ?>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#batalModal<?= $cuti['id_izin'] ?>">
                            Batalkan
                        </button>
                    </td>
                <?php else : ?>
                    <!-- Trigger Button -->
                    <td>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#beritaModal<?= $cuti['id_izin'] ?>">
                            Berita Acara
                        </button>
                    </td>
                <?php endif; ?>
            </tr>

            <!-- Modal Berita Acara -->
            <div class="modal fade" id="beritaModal<?= $cuti['id_izin'] ?>" tabindex="-1" aria-labelledby="beritaModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content text-dark">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Berita Acara</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/berita_acara/ajukan_batal_cuti" method="post">
                            <div class="modal-body">
                                <input type="text" name="id_izin" value="<?= $cuti['id_izin']; ?>" hidden>
                                <input type="text" name="izin_awal" value="<?= $cuti['izin_awal']; ?>" hidden>
                                <input type="text" name="alasan_izin" value="<?= $cuti['alasan_izin']; ?>" hidden>
                                <input type="text" name="total_cuti" value="<?= $cuti['total_cuti']; ?>" hidden>
                                <input type="text" name="periode_cuti" value="<?= $cuti['periode_cuti']; ?>" hidden>
                                <label for="alasan_batal">Alasan pembatalan Cuti / Izin:</label>
                                <textarea name="alasan_batal" id="alasan_batal" class="form-control" rows="3" require></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Ajukan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Batal -->
            <div class="modal fade" id="batalModal<?= $cuti['id_izin'] ?>" tabindex="-1" role="dialog" aria-labelledby="batalModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-dark" id="exampleModalLabel">Batalkan cuti ?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-footer">
                            <form action="/hr/cuti/batal/<?= $cuti['id_izin'] ?>" method="post">
                                <button type="submit" class="btn btn-danger">Batalkan</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--Kartu Cuti Modal-->
            <div class="modal fade" id="editModal<?= $cuti['id_izin'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $cuti['id_izin'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-l" role="document">
                    <div class="card shadow-sm text-dark">
                        <div class="card-header">
                            <h5 class="mb-0">Kartu Cuti</h5>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form>
                                    Dibuat Pada : <?= $cuti['tanggal_dibuat'] ?>
                                    <div class="form-row border-top border-muted form mt-3">
                                        <div class="form-group col-md-6">
                                            <label for="alasan_izin">Tanggal cuti :</label>
                                            <input type="text" class="form-control" name="keterangan_waktu" value="<?= date('d-m-Y', strtotime($cuti['izin_awal'])) ?>" disabled>
                                        </div>
                                        <div class="form-group col-md-6" id="keterangan_waktu"> <!-- start_time -->
                                            <label for="keterangan_waktu">Sampai Dengan :</label>
                                            <input type="text" class="form-control" name="keterangan_waktu" value="<?= $cuti['izin_akhir'] ? date('d-m-Y', strtotime($cuti['izin_akhir'])) : '' ?>" disabled>
                                        </div>
                                        <div class="form-group col-md-6" id="total_cuti"> <!-- start_time -->
                                            <label for="total_cuti">Total Cuti : <?= $cuti['total_cuti']; ?> Hari</label>
                                        </div>
                                    </div>
                                    <div class="form-row border-top border-bottom border-muted form mt-1">
                                        <div class="form-group col-md-12">
                                            <label for="reason">Alasan cuti</label>
                                            <textarea class="form-control" id="keterangan" name="keterangan" disabled><?= $cuti['keterangan']; ?></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="reason">Telepon</label>
                                            <input type="text" class="form-control" value="<?= $cuti['telp'] ?>" disabled>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="reason">Alamat</label>
                                            <textarea class="form-control" name="keterangan_waktu" value="<?= $cuti['alamat'] ?>" disabled></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="reason">Approval Atasan</label> <br>
                                            <?= $cuti['approval1'] == 1 ? '<span style="color: green; font-weight:bold">✓</span>' : ($cuti['approval1'] == 9 ? '<span style="color: red; font-weight:bold">✗</span>' : '<span style="color: orchid; font-weight:bold">?</span>'); ?> - <?= $cuti['atasan']; ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="reason">Approval Kadept</label> <br>
                                            <?= $cuti['approval2'] == 1 ? '<span style="color: green; font-weight:bold">✓</span>' : ($cuti['approval2'] == 9 ? '<span style="color: red; font-weight:bold">✗</span>' : '<span style="color: orchid; font-weight:bold">?</span>'); ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endsection() ?>