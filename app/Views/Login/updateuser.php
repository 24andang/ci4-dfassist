<html>

<head>
    <title>My Form</title>
</head>

<body>
    <form action="/updateuser/<?= $user['id']; ?>" method="post">
        <?= csrf_field() ?>
        <h5>Inisial</h5>
        <input type="text" name="inisial" value="<?= $user['id']; ?>" hidden>

        <h5>Inisial</h5>
        <input type="text" name="inisial" value="<?= $user['inisial']; ?>" maxlength="3">

        <h5>Nama</h5>
        <input type=" text" name="nama" value="<?= $user['nama']; ?>">

        <h5>Dept</h5>
        <input type=" text" name="dept" value="<?= $user['dept']; ?>">

        <h5>Jabatan</h5>
        <input type=" text" name="jabatan" value="<?= $user['jabatan']; ?>">

        <h5>Pass</h5>
        <input type="text" name="pass" value="<?= $user['pass']; ?>">

        <h5>Konfirmasi Pass</h5>
        <input type="text" name="konfpass" value="">

        <div><input type="submit" value="Submit"></div>
    </form>
</body>

</html>