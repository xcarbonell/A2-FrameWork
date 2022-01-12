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
    <section class="gestorTasks">
        <article>
            <h4>Administració de cursos</h4>
            <br>
            <table>
                <tr>
                    <th colspan="2">Cursos</th>
                </tr>
                <tr>
                    <td>NOM</td>
                    <td>SIGLES</td>
                </tr>
                <?php
                for ($i = 0; $i < count($cursos); $i++) {
                    echo '<tr><td>' . $cursos[$i]['name'] . '</td><td>' . $cursos[$i]['acronym'] . '</td></tr>';
                }
                ?>
            </table>
        </article>
        <article>
            <h4>Afegir nou curs</h4>
            <br>
            <form action="\admincourses\addCourse" method="post">
                <input type="text" name="addCourseName" placeholder="Nom">
                <input type="text" name="addCourseAcronym" placeholder="Sigles">
                <br>
                <br>
                <button type="submit">Afegeix</button>
            </form>
        </article>
        <article>
            <h4>Modificar dades d'un curs existent</h4>
            <br>
            <form action="\admincourses\updateCourse" method="post">
                <select name="updateCourseId">
                    <option disabled selected>SELECCIONA CURS</option>
                    <?php
                    for ($i = 0; $i < count($cursos); $i++) {
                        echo '<option value="' . $cursos[$i]["id"] . '">' . $cursos[$i]["name"] . ' (' . $cursos[$i]["acronym"] . ')</option>';
                    }
                    ?>
                </select>
                <br>
                <br>
                <label for="updateCourseName">Introdueix nou nom:</label>
                <input type="text" name="updateCourseName" placeholder="Nom">
                <br>
                <label for="updateCourseAcronym">Introdueix les noves sigles:</label>
                <input type="text" name="updateCourseAcronym" placeholder="Sigles">
                <br>
                <br>
                <button type="submit">Guarda els canvis</button>
            </form>
        </article>
        <article>
            <h4>Esborrar curs</h4>
            <form action="\admincourses\deleteCourse" method="post">
                <br>
                <select name="deleteCourseId">
                    <option disabled selected>SELECCIONA CURS</option>
                    <?php
                    for ($i = 0; $i < count($cursos); $i++) {
                        echo '<option value="' . $cursos[$i]["id"] . '">' . $cursos[$i]["name"] . ' (' . $cursos[$i]["acronym"] . ')</option>';
                    }
                    ?>
                </select>
                <br>
                <br>
                <button type="submit" class="crudTasks">Esborra</button>
            </form>
        </article>
        <article>
            <a href="\dashboard">Torna al Dashboard</a>
        </article>
    </section>
</body>

</html>