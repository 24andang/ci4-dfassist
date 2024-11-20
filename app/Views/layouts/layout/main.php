<!doctype html>
<html lang="en">

<head>
    <link rel="icon" href="assets\logo-dfa.png" type="image/gif">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="../style/bootstrap.bundle.min.js"></script>

    <title>DFA</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #282c34;
            color: white;
            overflow: hidden;
        }

        /* .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: rgba(40, 44, 52, 0.9);
            padding: 10px 0;
            z-index: 2;
            display: flex;
            justify-content: center;
        } */

        /* .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 1.2em;
            transition: color 0.3s ease;
        } */

        .navbar a:hover {
            color: #61dafb;
        }

        /* .container {
            text-align: center;
            position: relative;
            z-index: 1;
            margin-top: 60px; /* To avoid overlap with the navbar 
        } */

        .welcome-text {
            font-size: 3em;
            opacity: 0;
            animation: fadeIn 3s forwards, slideIn 3s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
            }

            to {
                transform: translateY(0);
            }
        }

        .background-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.20);
            animation: move 10s infinite ease-in-out;
        }

        @keyframes move {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                transform: translateY(100vh) translateX(100vw);
                opacity: 1;
            }
        }

        html,
        body {
            height: 100%;
            overflow-y: auto;
        }

        .full-height {
            height: 100vh;
        }

        /* .table-wrapper {
            max-height: 400px;
            overflow-y: auto;
        }

        .table th,
        .table td {
            white-space: nowrap;
        } */

        .dropdown-menu-right {
            left: 100%;
            top: 0;
            margin-left: 0.1rem;
            border-radius: 0.25rem;
        }

        .dropdown-submenu>.dropdown-menu {
            display: none;
            position: absolute;
            left: 100%;
            top: 0;
            margin-top: -6px;
            margin-left: 0;
        }

        .dropdown-menu {
            display: none;
        }

        /* Tampilkan dropdown-menu saat item di-hover */
        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
            position: absolute;
            left: 100%;
            top: 0;
            margin-top: -6px;
            margin-left: 0;
        }

        /* Pastikan dropdown-menu muncul di sebelah kanan item yang di-hover */
        .dropdown-submenu {
            position: relative;
        }

        table {
            border-collapse: collapse;
            table-layout: fixed;
            width: 310px;
        }

        table td {
            width: 100px;
            word-wrap: break-word;
        }
    </style>
</head>

<body>
    <div class="container">
        <?= $this->renderSection('content') ?>
    </div>

    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var action = '/admin/delete_modal/' + id; // Construct the delete URL

            var modal = $(this);
            modal.find('.modal-body').text('Are you sure you want to delete this item?');
            modal.find('#deleteForm').attr('action', action);
        });
    </script>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </script>
    <!-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            const welcomeText = document.querySelector('.welcome-text');
            welcomeText.classList.add('animated');
        });
    </script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../style/jquery.min.js"></script>
    <!-- Bootstrap Bundle JS (includes Popper.js) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.bundle.min.js"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--     
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->

    <!-- untuk excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

</body>

</html>