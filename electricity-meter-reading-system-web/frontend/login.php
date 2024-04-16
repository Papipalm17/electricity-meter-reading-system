<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>

    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Sarabun:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/StyleLogin.css">
</head>

<?php

session_start();
include '../DB/connect.php';
unset($_SESSION['user_login']);
unset($_SESSION['admin_login']);
?>

<body>

    <!-- Section: Design Block -->
    <section class="background-radial-gradient overflow-hidden">

        <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
            <div class="row gx-lg-5 align-items-center mb-5">
                <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                    <h2 class="my-5 display-6 fw-bold ls-tight" id="span-1">AGUYA</h2>
                    <span id="span-2">Electricity Meter Reading System with Image Processing based on Internet of Things</span>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                    <div class="card bg-glass">
                        <div class="card-body px-4 py-5 px-md-5">
                            <form action="../backend/login_DB.php" method="post">
                                <?php if (isset($_SESSION['error'])) : ?>
                                    <div class="error">
                                        <h3>
                                            <?php
                                            echo $_SESSION['error'];
                                            unset($_SESSION['error']);
                                            ?>
                                        </h3>
                                    </div>
                                <?php endif ?>
                                <!-- Username input -->
                                <div class="form-outline mb-4 div_input">
                                    <label class="form-label" for="form3Example4">Username</label>
                                    <input type="text" id="username" name="username" class="form-control" required />
                                </div>

                                <!-- Password input -->
                                <div class="form-outline mb-4 div_input">
                                    <label class="form-label" for="form3Example4">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" required />
                                </div>

                                <!-- Submit button -->
                                <button type="submit" class="btn btn-primary btn-block mb-4" id="btn_login" name="btn_login"> 
                                    Log In
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section: Design Block -->

</body>

</html>