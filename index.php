<?php

    require_once './functions.php';

    session_start();

    $_user = $_SESSION['id'] ?? 0;
    if ( $_user ) {
        header( "Location: words.php" );
        exit;
    }

?>

<!doctype html>
<html lang="en" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark" />
    <link rel="stylesheet" href="./assets/pico.min.css">
    <link rel="stylesheet" href="./assets/styles.css">
    <title>Vocabulary Builder</title>
</head>

<body>
    <main class="container">
        <h1 class="tc mb-3">My Vocabularies</h1>
        <div class="tc mb-3">
            <a href="#" id="login" class="links nav_link">Login</a> | <a href="#" id="register"
                class="links nav_link">Register</a>
        </div>
        <div class="form_field" id="formchange">
            <h3 class="tc">Login</h3>
            <?php
                $status = $_GET['status'] ?? 0;
            if ( $status ): ?>
            <blockquote>
                <?=getStatusMessage( $status );?>
            </blockquote>
            <?php endif;?>

            <form action="./query.php" method="POST">
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off">
                </div>
                <input type="hidden" name="action" id="action" value="login">
                <button type="submit" class="secondary btn">Submit</button>
            </form>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js"></script>
    <script src="./assets/main.js"></script>
</body>

</html>