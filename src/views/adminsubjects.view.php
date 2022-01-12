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
                    <th colspan="3">Assignatures</th>
                </tr>
                <tr>
                    <td>NOM</td>
                    <td>CURS</td>
                    <td>PROFESSOR</td>
                </tr>
                <?php
                for ($i = 0; $i < count($assignatures); $i++) {
                    echo '<tr><td>' . $assignatures[$i]['name'] . '</td><td>' . $assignatures[$i]['siglas'] . '</td><td>' . $assignatures[$i]['profe'] . '</td></tr>';
                }
                ?>
            </table>
        </article>
        <article>
            <h4>Afegir nova assignatura</h4>
            <br>
            <form action="\adminsubjects\addSubject" method="post">
                <input type="text" name="addSubjectName" placeholder="Nom">
                <br>
                <select name="addSubjectTeacher">
                    <option disabled selected>SELECCIONA PROFESSOR</option>
                    <?php
                    for ($i = 0; $i < count($professors); $i++) {
                        echo '<option value="' . $professors[$i]["id"] . '">' . $professors[$i]["name"] . ' (' . $professors[$i]["email"] . ')</option>';
                    }
                    ?>
                </select>
                <br>
                <select name="addSubjectCourse">
                    <option disabled selected>SELECCIONA CURS</option>
                    <?php
                    for ($i = 0; $i < count($cursos); $i++) {
                        echo '<option value="' . $cursos[$i]["id"] . '">' . $cursos[$i]["name"] . ' (' . $cursos[$i]["acronym"] . ')</option>';
                    }
                    ?>
                </select>
                <br>
                <br>
                <button type="submit">Afegeix</button>
            </form>
        </article>
        <article>
            <h4>Modificar dades d'una assignatura existent</h4>
            <br>
            <form action="\adminsubjects\updateSubject" method="post">
                <select name="updateSubjectId">
                    <option disabled selected>SELECCIONA ASSIGNATURA</option>
                    <?php
                    for ($i = 0; $i < count($assignatures); $i++) {
                        echo '<option value="' . $assignatures[$i]["id"] . '">' . $assignatures[$i]["name"] . ' (' . $assignatures[$i]["siglas"] . '-' . $assignatures[$i]['profe'] . ')</option>';
                    }
                    ?>
                </select>
                <br><select name="updateSubjectTeacher">
                    <option disabled selected>SELECCIONA EL NOU PROFESSOR</option>
                    <?php
                    for ($i = 0; $i < count($professors); $i++) {
                        echo '<option value="' . $professors[$i]["id"] . '">' . $professors[$i]["name"] . ' (' . $professors[$i]["email"] . ')</option>';
                    }
                    ?>
                </select>
                <br><select name="updateSubjectCourse">
                    <option disabled selected>SELECCIONA EL NOU CURS</option>
                    <?php
                    for ($i = 0; $i < count($cursos); $i++) {
                        echo '<option value="' . $cursos[$i]["id"] . '">' . $cursos[$i]["name"] . ' (' . $cursos[$i]["acronym"] . ')</option>';
                    }
                    ?>
                </select>
                <br>
                <label for="updateSubjectName">Introdueix el nou nom:</label>
                <input type="text" name="updateSubjectName" placeholder="Nom">
                <br>
                <br>
                <button type="submit">Modifica</button>
            </form>
        </article>
        <article>
            <h4>Esborrar curs</h4>
            <form action="\adminsubjects\deleteSubject" method="post">
                <br>
                <select name="deleteSubjectId">
                    <option disabled selected>SELECCIONA ASSIGNATURA</option>
                    <?php
                    for ($i = 0; $i < count($assignatures); $i++) {
                        echo '<option value="' . $assignatures[$i]["id"] . '">' . $assignatures[$i]["name"] . ' (' . $assignatures[$i]["siglas"] . '-' . $assignatures[$i]['profe'] . ')</option>';
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