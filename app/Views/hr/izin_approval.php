<?= $this->extend('\layouts\layout\main') ?>

<?= $this->section('content') ?>
<?= $this->include('\layouts\layout\navbar') ?>


<div class="d-flex justify-content-between align-items-center">
    <h1>Approval</h1>
    <div>
        <span class="me-2"><span style="color: red; font-weight:bold">*</span>Untuk Cuti, Approval2 = Manager/Kadept</span>
    </div>
</div>

<?php if (session()->getFlashdata('radio_zero')) : ?>
    <div class="alert alert-warning">
        <?= session()->getFlashdata('radio_zero') ?>
    </div>
<?php endif; ?>


<table class="table bg-light">
    <thead>
        <tr>
            <th scope="col" rowspan="2" style="vertical-align : middle;text-align:center;">Nama</th>
            <th scope="col" rowspan="2" style="vertical-align : middle;text-align:center;">Cuti/Izin</th>
            <th scope="col" rowspan="2" style="vertical-align : middle;text-align:center;">Alasan</th>
            <th scope="col" rowspan="2" style="vertical-align : middle;text-align:center;">Detail</th>
            <th colspan="2">
                <center>Approve</center>
            </th>
        </tr>
        <tr>

            <th scope="col" style="vertical-align : middle;text-align:center;">Atasan</th>
            <th scope="col" style="vertical-align : middle;text-align:center;">HR/Kadep</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($surat_izin as $izin) : ?>
            <?php if ($izin['approval1'] == 9 || $izin['approval1'] == 1 && $izin['approval2'] == 1 || $izin['approval2'] == 9) : ?>
                <?= ' '; ?>
            <?php else : ?>
                <tr>
                    <td><?= $izin['nama']; ?></td>
                    <td>
                        <?= $izin['alasan_izin'] == 'cuti' ? 'Cuti' : 'Izin'; ?>
                    </td>
                    <td><?= $izin['keterangan']; ?></td>
                    <td>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#detailModal<?= $izin['id_izin'] ?>">
                            Detail
                        </button>
                    </td>
                    <td>
                        <?php if ($izin['approval1'] == 1) : ?>
                            <span style="color: green; font-weight:bold">✓</span> Approved
                        <?php elseif ($izin['approval1'] == 9) : ?>
                            <span style="color: red; font-weight:bold">✗</span> Rejected
                        <?php elseif (session()->get('level') > $izin['level'] && session()->get('departemen') == $izin['departemen']) : ?>
                            <form action="/approval_satu/<?= $izin['id_izin']; ?>" method="post">
                                <input type="text" name="alasan_izin" value="<?= $izin['alasan_izin']; ?>" hidden>
                                <input type="radio" name="approval1" value=1> <span style="color: green; font-weight:bold">✓</span>
                                <input type="radio" name="approval1" value=9> <span style="color: red; font-weight:bold">✗</span>
                                <input type="text" name="atasan" value="<?= session()->get('inisial'); ?>" hidden>
                                <button class="btn btn-primary">Save</button>
                            </form>
                        <?php elseif (session()->get('level') == 4 && $izin['level'] == 3) : ?>
                            <form action="/approval_satu/<?= $izin['id_izin']; ?>" method="post">
                                <input type="text" name="alasan_izin" value="<?= $izin['alasan_izin']; ?>" hidden>
                                <input type="radio" name="approval1" value=1> <span style="color: green; font-weight:bold">✓</span>
                                <input type="radio" name="approval1" value=9> <span style="color: red; font-weight:bold">✗</span>
                                <input type="text" name="atasan" value="<?= session()->get('inisial'); ?>" hidden>
                                <button class="btn btn-primary">Save</button>
                            </form>

                        <?php else : ?>
                            <span class="me-2"><span style="color: orchid; font-weight:bold">?</span> <span class="fst-italic text-muted">Tunggu Approval</span>
                            <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($izin['alasan_izin'] == 'cuti' && session()->get('departemen') == $izin['departemen'] && session()->get('level') == 3 && $izin['approval1'] == 1) : ?>
                            <form action="/approval_hr/<?= $izin['id_izin']; ?>" method="post">
                                <input type="text" name="alasan_izin" value="<?= $izin['alasan_izin']; ?>" hidden>
                                <input type="radio" name="approval2" value="1"> <span style="color: green; font-weight:bold">✓</span>
                                <input type="radio" name="approval2" value="9"> <span style="color: red; font-weight:bold">✗</span>
                                <button class="btn btn-primary">Save</button>
                            </form>
                        <?php elseif ($izin['alasan_izin'] !== 'cuti' && session()->get('departemen') == 'HR & GA' && in_array(session()->get('inisial'), ['DKA', 'ODP', 'IAI', 'AWK', 'OAL']) && $izin['approval1'] == 1) : ?>
                            <form action="/approval_hr/<?= $izin['id_izin']; ?>" method="post">
                                <input type="text" name="alasan_izin" value="<?= $izin['alasan_izin']; ?>" hidden>
                                <input type="radio" name="approval2" value="1"> <span style="color: green; font-weight:bold">✓</span>
                                <input type="radio" name="approval2" value="9"> <span style="color: red; font-weight:bold">✗</span>
                                <button class="btn btn-primary">Save</button>
                            </form>
                        <?php elseif ($izin['approval2'] == 1) : ?>
                            <span style="color: green; font-weight:bold">✓</span> Approved
                        <?php elseif ($izin['approval2'] == 9) : ?>
                            <span style="color: green; font-weight:bold">✓</span> Rejected
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>

            <!-- modal -->
            <div class="modal fade" id="detailModal<?= $izin['id_izin'] ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel<?= $izin['id_izin'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-l" role="document">
                    <div class="card shadow-sm text-dark">
                        <div class="card-header">
                            <h5 class="mb-0">Detail</h5>
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
                                            <input type="text" class="form-control" name="keterangan_waktu" value="<?= date('d-m-Y', strtotime($izin['izin_awal'])); ?>" disabled>
                                        </div>
                                        <div class="form-group col-md-6" id="keterangan_waktu"> <!-- start_time -->
                                            <label for="keterangan_waktu">Sampai Dengan :</label>
                                            <input type="text" class="form-control" name="keterangan_waktu" value="<?= $izin['izin_akhir'] ? date('d-m-Y', strtotime($izin['izin_akhir'])) : ''; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-row border-top border-bottom border-muted form mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="reason">Keterangan</label>
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
                                            <label for="reason">Approval HR/Kadept</label> <br>
                                            <?= $izin['approval2'] == 1 ? '<span style="color: green; font-weight:bold">✓</span>' : ($izin['approval2'] == 9 ? '<span style="color: red; font-weight:bold">✗</span>' : '<span style="color: orchid; font-weight:bold">?</span>'); ?>
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

<?= $this->endSection() ?>