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
    <section class="gestorTasks">
        <article>
            <!--si el controlador ens diu que hi ha tasques mostrem la taula, en cas contrari mostrem un missatge-->
            <h4>Administració d'usuaris</h4>
            <br>
            <table>
                <tr>
                    <th colspan="3">Alumnes</th>
                </tr>
                <tr>
                    <td>NOM</td>
                    <td>EMAIL</td>
                    <td>CURS</td>
                </tr>
                <?php
                for ($i = 0; $i < count($alumnes); $i++) {
                    echo '<tr><td>' . $alumnes[$i]['name'] . '</td><td>' . $alumnes[$i]['email'] . '</td><td>' . $alumnes[$i]['acronym'] . '</td></tr>';
                }
                ?>
            </table>
            <br>
            <br>
            <table>
                <tr>
                    <th colspan="2">Professors</th>
                </tr>
                <tr>
                    <td>NOM</td>
                    <td>EMAIL</td>
                </tr>
                <?php
                for ($i = 0; $i < count($professors); $i++) {
                    echo '<tr><td>' . $professors[$i]['name'] . '</td><td>' . $professors[$i]['email'] . '</td></tr>';
                }
                ?>
            </table>
        </article>
        <article>
            <h4>Registrar nou usuari</h4>
            <form action="<?= root(); ?>register/reg" method="post">
                <input type="email" name="regEmail" placeholder="Email">
                <input type="password" name="regPasswd" placeholder="Password">
                <input type="password" name="regPasswdCheck" placeholder="Confirma la contrasenya">
                <input type="text" name="regNom" placeholder="Nom"><br>

                <input type="radio" id="alumne" name="regRol" value="student">
                <label for="alumne">Alumne</label>
                <input type="radio" id="profe" name="regRol" value="teacher">
                <label for="profe">Professor</label><br>
                <br>
                <button type="submit">Registrar</button>
            </form>
        </article>
        <article>
            <h4>Modificar dades d'un usuari existent</h4>
            <form action="<?= root(); ?>perfil/updatePerfil" method="post">
                <br>
                <select name="userUpdate">
                    <option disabled selected>SELECCIONA USUARI</option>
                    <option disabled> -- ALUMNES --</option>
                    <?php
                    for ($i = 0; $i < count($alumnes); $i++) {
                        echo '<option value="' . $alumnes[$i]["id"] . ';;students' . '">' . $alumnes[$i]["name"] . ' (' . $alumnes[$i]["email"] . ')</option>';
                    }
                    echo '<option disabled> -- PROFESSORS --</option>';
                    for ($i = 0; $i < count($professors); $i++) {
                        echo '<option value="' . $alumnes[$i]["id"] . ';;teachers' . '">' . $professors[$i]["name"] . ' (' . $professors[$i]["email"] . ')</option>';
                    }
                    ?>
                </select>
                <br>
                <br>
                <label for="nomUpdate">Introdueix nou nom:</label>
                <input type="text" name="nomUpdate" placeholder="Nom">
                <br>
                <label for="emailUpdate">Introdueix el nou email:</label>
                <input type="email" name="emailUpdate" placeholder="Email">
                <br>
                <label for="courseUpdate">Introdueix el nou curs (només per estudiants):</label>
                <select name="courseUpdate">
                    <option disabled selected>SELECCIONA CURS</option>
                    <?php
                    for ($i = 0; $i < count($cursos); $i++) {
                        echo '<option value="' . $cursos[$i]["id"] . '">' . $cursos[$i]["name"] . ' (' . $cursos[$i]["acronym"] . ')</option>';
                    }
                    ?>
                </select>
                <br>
                <br>
                <button type="submit">Guarda els canvis</button>
            </form>
        </article>
        <article>
            <h4>Esborrar usuari</h4>
            <form action="<?= root(); ?>adminusers/deleteUser" method="post">
                <br>
                <select name="deleteUser">
                    <option disabled selected>SELECCIONA USUARI</option>
                    <option disabled> -- ALUMNES --</option>
                    <?php
                    for ($i = 0; $i < count($alumnes); $i++) {
                        echo '<option value="' . $alumnes[$i]["id"] . ';;students' . '">' . $alumnes[$i]["name"] . ' (' . $alumnes[$i]["email"] . ')</option>';
                    }
                    echo '<option disabled> -- PROFESSORS --</option>';
                    for ($i = 0; $i < count($professors); $i++) {
                        echo '<option value="' . $alumnes[$i]["id"] . ';;teachers' . '">' . $professors[$i]["name"] . ' (' . $professors[$i]["email"] . ')</option>';
                    }
                    ?>
                </select>
                <br>
                <br>
                <button type="submit" class="crudTasks">Esborra</button>
            </form>
        </article>
        <article>
            <a href="<?= root(); ?>dashboard">Torna al Dashboard</a>
        </article>
    </section>
</body>

</html>