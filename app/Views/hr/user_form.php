<!-- File: app/Views/hr/user_form.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input NIK</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Form Input NIK</h1>

    <form>
        <label for="nik">NIK:</label>
        <input type="text" id="nik" name="nik" oninput="fetchUserData()">
        <br><br>

        <label for="inisial">Inisial:</label>
        <input type="text" id="inisial" name="inisial" readonly>
        <br><br>

        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" readonly>
        <br><br>

        <label for="departemen">Departemen:</label>
        <input type="text" id="departemen" name="departemen" readonly>
        <br><br>

        <label for="jabatan">Jabatan:</label>
        <input type="text" id="jabatan" name="jabatan" readonly>
        <br><br>

        <label for="tgl_join">Tanggal Join:</label>
        <input type="text" id="tgl_join" name="tgl_join" readonly>
    </form>

    <script>
        function fetchUserData() {
            var nik = $('#nik').val();
            if (nik.length > 0) {
                $.ajax({
                    url: "<?= site_url('hr/input/getUserByNik') ?>", // Sesuaikan dengan route baru
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
                            $('#departemen').val(data.departemen);
                            $('#jabatan').val(data.jabatan);
                            $('#tgl_join').val(data.tgl_join);
                        }
                    }
                });
            }
        }
    </script>
</body>

</html>