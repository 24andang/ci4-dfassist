<?php
$ip_address = $_SERVER['REMOTE_ADDR'];

$allowed_ips = ['192.168.200.253', '192.168.200.27', '192.168.200.240']; ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light rounded opacity-100">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/landing_page">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/reg-maklon">Maklon</a>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" role="button" id="mainDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            HR
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="mainDropdown">
                            <li class="dropdown-submenu">
                                <a class="dropdown-item" href="#">Izin</a>
                                <ul class="dropdown-menu">
                                    <?php if (session()->get('jabatan') !== 'Security' && session()->get('jabatan') !== 'Security Plant-2' || session()->get('inisial') == 'NIH'): ?>
                                        <li><a class="dropdown-item" href="/izin/<?= session()->get('id'); ?>">Pengajuan Izin</a></li>
                                    <?php endif; ?>
                                    <?php if (session()->get('departemen') == 'IT' || in_array(session()->get('jabatan'), ['Security', 'Security Plant-2']) && session()->get('inisial') != 'NIH') : ?>
                                        <li><a class="dropdown-item" href="/izin_security/<?= session()->get('inisial'); ?>">Pengajuan Izin Security</a></li>
                                    <?php endif; ?>
                                    <li><a class="dropdown-item" href="/hr/izin/history/<?= session()->get('inisial'); ?>">History Izin</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item" href="#">Cuti</a>
                                <ul class="dropdown-menu">
                                    <?php if (session()->get('jabatan') !== 'Security' && session()->get('jabatan') !== 'Security Plant-2' || session()->get('inisial') == 'NIH'): ?>
                                        <li><a class="dropdown-item" href="/cuti">Pengajuan Cuti</a></li>
                                    <?php endif; ?>
                                    <?php if (session()->get('departemen') == 'IT' || in_array(session()->get('jabatan'), ['Security', 'Security Plant-2']) && session()->get('inisial') != 'NIH') : ?>
                                        <li><a class="dropdown-item" href="/cuti-security/<?= session()->get('inisial'); ?>">Pengajuan Cuti Security</a></li>
                                    <?php endif; ?>
                                    <li><a class="dropdown-item" href="/cuti/spesial">Pengajuan Cuti Spesial</a></li>
                                    <li><a class="dropdown-item" href="/hr/cuti/history/<?= session()->get('inisial'); ?>">History Cuti</a></li>
                                </ul>
                            </li>
                            <?php if (session()->get('departemen') == 'IT' || in_array(session()->get('inisial'), ['IAI', 'AWK', 'DKA', 'ODP', 'OAL'])) : ?>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item" href="#">Input</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/input_hak_cuti">Hak Cuti Tahunan</a></li>
                                        <li><a class="dropdown-item" href="/hr/cuti/bersama">Cuti Bersama</a></li>
                                        <li><a class="dropdown-item" href="/hr/input/ganti_hari">Ganti Hari</a></li>
                                        <li><a class="dropdown-item" href="/hr/input/jadwal_security">Jadwal Security</a></li>
                                        <li><a class="dropdown-item" href="/hr/input/jadwal-security-plant-2">Jadwal Security Plant-2</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if (session()->get('departemen') == 'IT' || in_array(session()->get('inisial'), ['IAI', 'AWK', 'DKA', 'ODP', 'OAL'])) : ?>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item" href="#">Rekap</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/hr/rekap/kehadiran">Kehadiran</a></li>
                                        <li><a class="dropdown-item" href="/hr/rekap/cut-off">Cut Off</a></li>
                                        <li><a class="dropdown-item" href="/hr/rekap/hari_ini">Hari Ini</a></li>
                                        <li><a class="dropdown-item" href="/hr/rekap/departemen">Departemen</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
                <li class="nav-item" <?= (session()->get('level') >= 2 || in_array(session()->get('inisial'), ['DKA', 'ODP'])) ? '' : 'hidden'; ?>>
                    <a class="nav-link" href="/approval">Approval</a>
                    </a>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" role="button" id="mainDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Info
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="mainDropdown">
                            <li class="dropdown-submenu" <?= (session()->get('level') >= 2 || in_array(session()->get('inisial'), ['DKA', 'ODP', 'MDR', 'EMM'])) ? '' : 'hidden'; ?>>
                                <a class="dropdown-item" href="/info/kehadiran">Kehadiran</a>
                            </li>
                            <?php if (in_array($ip_address, $allowed_ips)): ?>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item" href="/info/penerimaan-paket">Penerimaan Paket</a>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item" href="/info/history-paket">History Paket</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
                <li class="nav-item" <?= (session()->get('departemen') == 'IT' || in_array(session()->get('inisial'), ['IAI', 'AWK', 'DKA', 'ODP', 'OAL'])) ? '' : 'hidden'; ?>>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" role="button" id="mainDropdown" data-bs-toggle="dropdown" aria-expanded="false" <?= session()->get('departemen') == 'IT' ? '' : ''; ?>>
                            Berita Acara
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="mainDropdown">
                            <li class="dropdown-submenu">
                                <a class="dropdown-item" href="#">HR</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/berita_acara/batalkan_cuti_izin">Batal Cuti & Izin</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin"><?= session()->get('departemen') == 'IT' ? 'Admin' : ''; ?></a>
                </li>
            </ul>

            <!-- Kanan -->
            <ul class="nav">
                <li class="nav-item dropdown dropstart">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button"><?= session()->get('inisial'); ?></a>
                    <ul class="dropdown-menu dropdown-menu-left mt-5">
                        <li>
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= session()->get('nama'); ?></h5>
                                    <p class="card-text"><?= session()->get('departemen'); ?></p>
                                    <a href="/gantipass/<?= session()->get('id'); ?>" class="card-link">Ganti Password</a>
                                    <a href="/logout" class="card-link">Log Out</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>