<?php

require_once './config.php';

$connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
mysqli_set_charset( $connection, "utf8" );

if ( !$connection ) {
    throw new Exception( "Cannot connect to database: " . mysqli_connect_error() );
}
function getStatusMessage( int $code = 0 ): string {
    $status = [
        '0' => '',
        '1' => 'Duplicate email address',
        '2' => 'Password must be 4 character or long',
        '3' => 'Email or Password is empty',
        '4' => 'User created successfully',
        '5' => 'Email or password didn\'t match',
        '6' => 'No user found',
    ];

    return $status[$code];
}

function getWords( int $user_id, string $word = null ): array {
    global $connection;

    if ( $word ) {
        $query = "SELECT * FROM words WHERE user_id = '{$user_id}' AND word LIKE '{$word}%' ORDER BY word";
    } else {
        $query = "SELECT * FROM words WHERE user_id = '{$user_id}' ORDER BY word";
    }

    $result = mysqli_query( $connection, $query );

    $data = [];
    while ( $_data = mysqli_fetch_assoc( $result ) ) {
        array_push( $data, $_data );
    }

    return $data;
}

function generateAlphabetOptions(): string {
    $output = '<option selected value="all">All Words</option>';
    foreach ( range( 'A', 'Z' ) as $char ) {
        $output .= "<option value=\"{$char}\">{$char}</option>";
    }

    return $output;
}