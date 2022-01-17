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
        <div id="title">
            <h1><?= $nom; ?></h1>
        </div>
        <div id="menuSup">
            <form action="<?= root(); ?>logout" method="post">
                <button type="submit">TANCAR SESSIO</button>
            </form>
        </div>
    </header>
    <nav>
        <h3>Hola <?= $_COOKIE['activeUser'] ?>, benvingut/da al teu dashboard!</h3>
    </nav>
    <section>
        <article id="tasks">
            <!--si el controlador ens diu que hi ha tasques mostrem la taula, en cas contrari mostrem un missatge-->
            <h4>Llistat de Tasques</h4>
            <br>
            <?php if ($quedenTasques) : ?>
                <table>
                    <tr>
                        <th>Nom de la tasca</th>
                        <th>Estat</th>
                    </tr>
                    <?php
                    for ($i = 0; $i < count($llistatTasques); $i++) {
                        for ($j = 0; $j < count($llistatTasques[$i]); $j++) {
                            echo '<tr>' . '<td>' . $llistatTasques[$i][$j]['item'] . '</td>';
                            if ($llistatTasques[$i][$j]['completed']) {
                                echo '<td>Acabat/ada</td></tr>';
                            } else {
                                echo '<td>Per acabar</td></tr>';
                            }
                        }
                    }
                    ?>
                </table>
            <?php else : ?>
                <p>No tens tasques per realitzar</p>
            <?php endif ?>
            <br>
            <a href="<?= root(); ?>tasks">Gestiona les tasques</a>
            <br>
            <br>
            <a href="<?= root(); ?>lists">Gestiona les llistes</a>
        </article>
        <article id="perfil">
            <h4>Gestió del perfil</h4>
            <br>
            <p>Nom: <?= $_COOKIE['activeUser'] ?></p>
            <p>Email: <?= $_COOKIE['emailUser'] ?></p>
            <br>
            <a href="<?= root(); ?>perfil">Modifica el perfil</a>
            <?php if ($userRole == 1) : ?>
                <br>
                <br>
                <a href="<?= root(); ?>curs">Visualitza cursos, materies i alumnat</a>
            <?php endif ?>
        </article>
        <?php if ($userRole == 2) : ?>
            <article>
                <h4>Administració</h4>
                <br>
                <a href="<?= root(); ?>adminusers">Administrar usuaris</a>
                <br>
                <br>
                <a href="<?= root(); ?>admincourses">Administrar cursos</a>
                <br>
                <br>
                <a href="<?= root(); ?>adminsubjects">Administrar assignatures</a>
            </article>
        <?php endif ?>
    </section>
</body>

</html>