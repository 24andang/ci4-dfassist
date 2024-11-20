<?= $this->extend('\Login\layouts\layout') ?>

<?= $this->section('content') ?>
<?= $this->include('\Login\layouts\navbar') ?>

<div class="dialog xl mdialog-centered modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-body">
            <table class="table">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 style="color : black">History Izin</h1>
                    <div>
                        <span style="color : black" class="me-2"><span style="color: orchid; font-weight:bold">?</span>= Menunggu</span>
                        <span style="color : black" class="me-2"><span style="color: green; font-weight:bold">✓</span>= Disetujui</span>
                        <span style="color : black"><span style="color: red; font-weight:bold">✗</span>= Ditolak</span>
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

                <thead>
                    <tr>
                        <th style="width : 20%">Nomor Izin</th>
                        <th style="width : 35%">Izin</th>
                        <th style="width : 10%">Tanggal</th>
                        <th style="width : 10%">Approval</th>
                        <th style="width : 10%">Detail</th>
                        <th style="width : 15%">Batal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($surat_izin as $izin) : ?>
                        <tr>
                            <td><?= session()->get('departemen') . '/' . session()->get('inisial') . '/' . $izin['id_izin'] ?>/I</td>
                            <td><?= $izin['alasan_izin'] ?></td>
                            <td><?= date('d-m-y', strtotime($izin['izin_awal'])) ?></td>
                            <td>
                                <?= $izin['approval1'] == 1 ? '<span style="color: green; font-weight:bold">✓</span>' : ($izin['approval1'] == 9 ? '<span style="color: red; font-weight:bold">✗</span>' : '<span style="color: orchid; font-weight:bold">?</span>'); ?>
                                <?= $izin['approval2'] == 1 ? '<span style="color: green; font-weight:bold">✓</span>' : ($izin['approval2'] == 9 ? '<span style="color: red; font-weight:bold">✗</span>' : '<span style="color: orchid; font-weight:bold">?</span>'); ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editModal<?= $izin['id_izin'] ?>">
                                    Kartu
                                </button>
                            </td>
                            <?php if ($izin['approval1'] == 0): ?>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#batalModal<?= $izin['id_izin'] ?>">
                                        Batalkan
                                    </button>
                                </td>
                            <?php else : ?>
                                <!-- Trigger Button -->
                                <td>
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#beritaModal<?= $izin['id_izin'] ?>">
                                        Berita Acara
                                    </button>
                                </td>
                            <?php endif; ?>
                        </tr>



                        <!-- Modal Berita Acara -->
                        <div class="modal fade" id="beritaModal<?= $izin['id_izin'] ?>" tabindex="-1" aria-labelledby="beritaModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content text-dark">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Berita Acara</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/berita_acara/ajukan_batal_izin" method="post">
                                        <div class="modal-body">
                                            <input type="text" name="id_izin" value="<?= $izin['id_izin']; ?>" hidden>
                                            <input type="text" name="izin_awal" value="<?= $izin['izin_awal']; ?>" hidden>
                                            <input type="text" name="alasan_izin" value="<?= $izin['alasan_izin']; ?>" hidden>
                                            <input type="text" name="total_cuti" value="<?= $izin['total_cuti']; ?>" hidden>
                                            <input type="text" name="periode_cuti" value="<?= $izin['periode_cuti']; ?>" hidden>
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

                        <!--Kartu Izin Modal-->
                        <div class="modal fade" id="editModal<?= $izin['id_izin'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $izin['id_izin'] ?>" aria-hidden="true">
                            <div class="modal-dialog modal-l" role="document">
                                <div class="card shadow-sm text-dark">
                                    <div class="card-header">
                                        <h5 class="mb-0">Kartu Izin</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="container">
                                            <form action="/hr/izin/create" method="post">
                                                Dibuat Pada : <?= $izin['tanggal_dibuat'] ?>
                                                <div class="form-row border-top border-muted form mt-3">
                                                    <div class="form-group col-md-6">
                                                        <label for="alasan_izin">Alasan Izin :</label>
                                                        <input type="text" class="form-control" name="keterangan_waktu" value="<?= $izin['alasan_izin'] ?>" disabled>
                                                    </div>
                                                    <div class="form-group col-md-6" id="keterangan_waktu"> <!-- start_time -->
                                                        <label for="keterangan_waktu" style="color: white;">Sub :</label>
                                                        <input type="text" class="form-control" name="keterangan_waktu" value="<?= $izin['sub_alasan'] ?>" disabled>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="alasan_izin">Tanggal Izin :</label>
                                                        <input type="text" class="form-control" name="keterangan_waktu" value="<?= date('d-m-Y', strtotime($izin['izin_awal'])) ?>" disabled>
                                                    </div>
                                                    <div class="form-group col-md-6" id="keterangan_waktu"> <!-- start_time -->
                                                        <label for="keterangan_waktu">Sampai Dengan :</label>
                                                        <input type="text" class="form-control" name="keterangan_waktu" value="<?= $izin['izin_akhir'] ? date('d-m-Y', strtotime($izin['izin_akhir'])) : '' ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-row border-top border-bottom border-muted form mt-3">
                                                    <div class="form-group col-md-12">
                                                        <label for="reason">Keterangan Izin</label>
                                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" disabled><?= $izin['keterangan']; ?></textarea>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="reason">Kendaraan yang digunakan</label>
                                                        <input type="text" class="form-control" value="<?= $izin['kendaraan'] ?>" disabled>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="reason">Pengemudi</label>
                                                        <input type="text" class="form-control" name="keterangan_waktu" value="<?= $izin['pengemudi'] ?>" disabled>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="reason">Approval Atasan</label> <br>
                                                        <?= $izin['approval1'] == 1 ? '<span style="color: green; font-weight:bold">✓</span>' : ($izin['approval1'] == 9 ? '<span style="color: red; font-weight:bold">✗</span>' : '<span style="color: orchid; font-weight:bold">?</span>'); ?> - <?= $izin['atasan']; ?>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="reason">Approval HR</label> <br>
                                                        <?= $izin['approval2'] == 1 ? '<span style="color: green; font-weight:bold">✓</span>' : ($izin['approval2'] == 9 ? '<span style="color: red; font-weight:bold">✗</span>' : '<span style="color: orchid; font-weight:bold">?</span>'); ?>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Batal -->
                        <div class="modal fade" id="batalModal<?= $izin['id_izin'] ?>" tabindex="-1" role="dialog" aria-labelledby="batalModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-dark" id="exampleModalLabel">Batalkan izin ?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="/hr/izin/batal/<?= $izin['id_izin'] ?>" class="btn btn-danger">Batalkan</a>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endsection() ?>