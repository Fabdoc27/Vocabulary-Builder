<?php

    session_start();

    require_once './functions.php';

    $_user = $_SESSION['id'] ?? 0;
    if ( !$_user ) {
        header( "Location: index.php" );
        exit;
    }

    if ( isset( $_POST['submit'] ) ) {
        $searchWord = $_POST['search'];
        $words = getWords( $_user, $searchWord );
    } else {
        $words = getWords( $_user );
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
    <main class="container-fluid">
        <aside class="sidebar flexbox dir_col justify_center align_center">
            <h3>Menu</h3>
            <ul>
                <li><a href="#" class="menu_item" data-target="allwords">All Words</a></li>
                <li><a href="#" class="menu_item" data-target="wordsform">Add New Words</a></li>
                <li><a href="./logout.php">Logout</a></li>
            </ul>
        </aside>

        <h1 class="title tc mb-4">My Vocabularies</h1>

        <div class="hitems" id="allwords">
            <div class="mb-3 grid searchbox">
                <select name="favorite-cuisine" class="mb-0" id="alphabets">
                    <?=generateAlphabetOptions();?>
                </select>
                <div></div>
                <form method="POST" class="grid">
                    <input type="search" name="search" placeholder="Search" class="mb-0" />
                    <button type="submit" name="submit" value="submit" class="mb-0">Search</button>
                </form>
            </div>

            <table class="striped words">
                <thead>
                    <tr>
                        <th scope="col" class="tc" width="30%">Word</th>
                        <th scope="col" class="tc">Definition</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $words as $word ): ?>
                    <tr>
                        <th scope="row" class="tc"><?=$word['word'];?></th>
                        <td class="tc"><?=$word['meaning'];?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>

        <div class="hitems" id="wordsform" style="display:none;">
            <form action="./query.php" method="POST">
                <h3 class="mb-3">Add New Word</h3>
                <div class="grid">
                    <div>
                        <label for="word">Word</label>
                        <input type="text" name="word" id="word">
                    </div>
                    <div>
                        <label for="meaning">Meaning</label>
                        <input type="text" name="meaning" id="meaning">
                    </div>
                </div>
                <input type="hidden" name="action" value="addword">
                <button type="submit" class="secondary btn">Add</button>
            </form>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js"></script>
    <script src="./assets/main.js"></script>
</body>

</html>