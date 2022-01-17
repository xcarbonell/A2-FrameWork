<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School</title>
    <link type="text/css" rel="stylesheet" href="<?php root(); ?>public/css/estil.css" />
</head>

<body>
    <header>
        <h1><?= $nom; ?></h1>
    </header>
    <nav>
        <ul>
            <li>
                <a href="<?= root(); ?>login">LOGIN</a>
            </li>
            <li>
                <a href="<?= root(); ?>register">REGISTER</a>
            </li>
        </ul>
    </nav>
</body>

</html>