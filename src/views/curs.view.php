<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School</title>
    <link type="text/css" rel="stylesheet" href="public/css/estil.css" />
</head>

<body>
    <header>
        <div id="title">
            <h1><?= $nom; ?></h1>
        </div>
        <div id="menuSup">
            <form action="\logout" method="post">
                <button type="submit">TANCAR SESSIO</button>
            </form>
        </div>
    </header>
    <section>
        <article id="tasks">
            <h4>Llistat de Cursos</h4>
            <br>
            <?php
            for ($i = 0; $i < count($cursos); $i++) {
                echo '<table><tr><th colspan="2">' . $cursos[$i][0]["name"] . ' (' . $cursos[$i][0]["acronym"] . ')</tr></th>';
                echo '<tr><td colspan="2">' . $materies[$i]['name'] . '</td></tr>';
                echo '<tr><td>Nom</td><td>Email</td></tr>';
                for ($j = 0; $j < count($alumnes[$i]); $j++) {
                    echo '<tr>' . '<td>' . $alumnes[$i][$j]["name"] . '</td>';
                    echo '<td>' . $alumnes[$i][$j]["email"] . '</td></tr>';
                }
                echo '</table><br><br>';
            }
            ?>
            <a href="\dashboard">Torna al Dashboard</a>
        </article>
    </section>
</body>

</html>