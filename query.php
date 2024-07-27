<?php

session_start();

require_once './config.php';

$action = $_POST['action'] ?? "";
$status = 0;

$connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
mysqli_set_charset( $connection, "utf8" );

if ( !$connection ) {
    throw new Exception( "Cannot connect to database: " . mysqli_connect_error() );
} else {
    if ( !$action ) {
        header( "Location: index.php" );
        die();
    } else {
        // register user
        if ( $action == "register" ) {
            $useremail = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL );
            $password = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS );

            if ( $useremail && $password ) {
                $email = filter_var( $useremail, FILTER_VALIDATE_EMAIL );

                if ( $email && strlen( $password ) >= 4 ) {
                    $email = mysqli_real_escape_string( $connection, $email );

                    $duplicateCheck = "SELECT email FROM users WHERE email = '{$email}'";
                    $duplicateResult = mysqli_query( $connection, $duplicateCheck );

                    if ( $duplicateResult && mysqli_num_rows( $duplicateResult ) > 0 ) {
                        $status = 1; // Duplicate email address
                    } else {
                        $hash = password_hash( $password, PASSWORD_BCRYPT );
                        $query = "INSERT INTO users (email, password) VALUES ('{$email}','{$hash}')";
                        $result = mysqli_query( $connection, $query );

                        if ( $result ) {
                            $status = 4;
                        }
                    }
                } else {
                    $status = 2;
                }
            } else {
                $status = 3;
            }

            header( "Location: index.php?status={$status}" );
        }
        // login user
        elseif ( $action == 'login' ) {
            $useremail = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL );
            $password = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS );

            if ( $useremail && $password ) {
                $email = filter_var( $useremail, FILTER_VALIDATE_EMAIL );

                $query = "SELECT id, password FROM users WHERE email='{$useremail}'";
                $result = mysqli_query( $connection, $query );

                if ( $result && mysqli_num_rows( $result ) > 0 ) {
                    $data = mysqli_fetch_assoc( $result );
                    $_password = $data['password'];
                    $_id = $data['id'];

                    if ( password_verify( $password, $_password ) ) {
                        $_SESSION['id'] = $_id;
                        header( "Location: words.php" );
                        exit();
                    } else {
                        $status = 5;
                    }
                } else {
                    $status = 6;
                }
            } else {
                $status = 3;
            }

            header( "Location: index.php?status={$status}" );
        }
        // add word
        elseif ( $action == 'addword' ) {
            $word = filter_input( INPUT_POST, 'word', FILTER_SANITIZE_SPECIAL_CHARS );
            $meaning = filter_input( INPUT_POST, 'meaning', FILTER_SANITIZE_SPECIAL_CHARS );
            $user_id = $_SESSION['id'] ?? 0;

            if ( $word && $meaning && $user_id ) {
                $word = mysqli_real_escape_string( $connection, $word );
                $meaning = mysqli_real_escape_string( $connection, $meaning );

                $query = "INSERT INTO words (user_id, word, meaning) VALUES ('{$user_id}','{$word}','{$meaning}')";
                $result = mysqli_query( $connection, $query );
            }

            header( "Location: words.php" );
        }
    }
}

mysqli_close( $connection );