<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School</title>
    <link type="text/css" rel="stylesheet" href="public/css/estil.css"/>
</head>

<body>
    <header>
        <h1><?= $nom; ?></h1>
    </header>
    <nav>
        <ul>
            <li>
                <a href="\register">REGISTER</a>
            </li>
            <li>
                <a href="\index">HOME</a>
            </li>
        </ul>
    </nav>
    <section>
        <article>
            <?php if (isset($_COOKIE['recorda'])) : ?>
                <p>La teva última connexió va ser: <?= $data ?></p><br>
            <?php endif ?>

            <form action="\login\log" method="post">
                <?php if (!isset($_COOKIE['recorda'])) : ?>
                    <input type="email" name="email" placeholder="Email">
                    <input type="password" name="passwd" placeholder="Password">
                <?php else : ?>
                    <input type="email" name="email" value="<?= $_COOKIE['emailUser'] ?>">
                    <input type="password" name="passwd" value="">
                <?php endif ?>
                <br>
                <input type="radio" name="tipusUser" value="admins">Admin
                <input type="radio" name="tipusUser" value="teachers">Professor
                <input type="radio" name="tipusUser" value="students">Estudiant
                <br>
                <input type="checkbox" id="recorda" name="recorda" value="1">
                <label for="recorda">Mante la sessio iniciada</label><br>
                <br><br>
                <button type="submit">Login</button>
            </form>
            <br>
            <form action="\reset" method="post">
                <button type="submit">Elimina les dades d'inici de sessio</button>
            </form>
        </article>
    </section>

</body>

</html>