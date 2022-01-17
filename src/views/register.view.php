<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School</title>
    <link type="text/css" rel="stylesheet" href="<?php root(); ?>public/css/estil.css">
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
                <a href="<?= root(); ?>index">HOME</a>
            </li>
        </ul>
    </nav>
    <section>
        <article>
            <form action="<?= root(); ?>register/reg" method="post">
                <input type="email" name="regEmail" placeholder="Email">
                <input type="password" name="regPasswd" placeholder="Password">
                <input type="password" name="regPasswdCheck" placeholder="Confirma la contrasenya">
                <input type="text" name="regNom" placeholder="Nom"><br>

                <input type="radio" id="alumne" name="regRol" value="student">
                <label for="alumne">Alumne</label>
                <input type="radio" id="profe" name="regRol" value="teacher">
                <label for="profe">Professor</label><br>

                <button type="submit">Register</button>
            </form>
        </article>

    </section>

</body>

</html>