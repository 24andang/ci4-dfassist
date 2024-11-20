<?= $this->extend('\Login\layouts\layout') ?>

<?= $this->section('content') ?>

<div class="background-animation">
    <?php for ($i = 0; $i < 30; $i++) : ?>
        <div class="circle" style="width: <?= rand(20, 100); ?>px; height: <?= rand(20, 100); ?>px; top: <?= rand(-100, 100); ?>%; left: <?= rand(-100, 100); ?>%; animation-delay: <?= rand(0, 10); ?>s;"></div>
    <?php endfor; ?>
</div>

<?= $this->include('\Login\layouts\navbar') ?>

<center>
<img src="assets\dfassist1.png" alt="Welcome Image" style="margin-top : 20%" class="welcome-image">
</center>
</div>



<?= $this->endSection() ?>