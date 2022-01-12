<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School</title>
    <link type="text/css" rel="stylesheet" href="public/css/estil.css">
</head>

<body>
    <header>
        <h1><?= $nom; ?></h1>
        <div id="menuSup">
            <form action="\logout" method="post">
                <button type="submit">TANCAR SESSIO</button>
            </form>
        </div>
    </header>
    <nav>
        <h3>Hola <?= $_COOKIE['activeUser'] ?>, abans de començar has de matricular-te!</h3>
    </nav>
    <section>
        <article>
            <form action="\matricula\inscripcio" method="post">
                <label for="cursos">Selecciona uns estudis:</label>
                <br>
                <select name="llistaCursos" id="cursos">
                    <?php
                    for ($i = 0; $i < count($cursos); $i++) {
                        echo '<option value="' . $cursos[$i]["id"] . '">' . $cursos[$i]["name"] . ' (' . $cursos[$i]["acronym"] . ')</option>';
                    }
                    ?>
                </select>
                <br>
                <br>
                <p>Atenció: abans de completar el registre has d'estar segur d'escollir el curs correcte. Si t'equivoques hauràs d'obrir un ticket a l'administrador per a que et canvïi al curs correcte</p>
                <br>
                <button type="submit">Matricula'm!</button>
            </form>
        </article>
    </section>
</body>

</html>