<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login - Admin</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/main.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center align-items-center" style="height: 100vh;">

            <div class="col-xl-6 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <?php if (isset($_SESSION['error'])): ?>
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: '<?= addslashes($_SESSION["error"]) ?>',
                                });
                            </script>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>

                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4" id="typing-text"></h1>
                            </div>
                            <form class="user" action="process/login.php" method="POST">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control form-control-user" aria-describedby="emailHelp"
                                        placeholder="Enter Username" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-user"
                                        id="password" placeholder="Password" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script>
        const text = "Hallo, Welcome!";
        const typingElement = document.getElementById("typing-text");
        let index = 0;

        function typeText() {
            if (index < text.length) {
            typingElement.innerHTML += text.charAt(index);
            index++;
            setTimeout(typeText, 100); // kecepatan ngetik (ms)
            }
        }

        typeText();
    </script>


    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>