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
            <!--si el controlador ens diu que hi ha tasques mostrem la taula, en cas contrari mostrem un missatge-->
            <h4>Tasques</h4>
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
        </article>
       <article>
            <h4>Crear tasca</h4>
            <form action="\tasks\createTask" method="post">
                <label for="item">Introdueix el nom:</label>
                <input type="text" name="item" placeholder="Nom">
                <br>
                <label for="completedCreate">Marca aquesta opcio si esta acabada:</label>
                <input type="checkbox" name="completedCreate">
                <br>
                <label for="cursos">Selecciona la llista a on afegir la nova tasca:</label>
                <br>
                <select name="llistes">
                    <?php
                    for ($i = 0; $i < count($llistes); $i++) {
                        echo '<option value="' . $llistes[$i]["id"] . '">' . $llistes[$i]["listName"] . '</option>';
                    }
                    ?>
                </select>
                <br>
                <br>
                <button type="submit" class="crudTasks">Crea tasca</button>
            </form>
        </article>
        <article>
            <h4>Modificar tasca</h4>
            <form action="\tasks\updateTask" method="post">
                <label for="updateTaskList">Selecciona una tasca:</label>
                <br>
                <select name="updateTaskList">
                    <?php
                    for ($i = 0; $i < count($llistatTasques); $i++) {
                        for ($j = 0; $j < count($llistatTasques[$i]); $j++) {
                            if ($llistatTasques[$i][$j]["completed"]) {
                                $completed = "Acabada";
                            } else {
                                $completed = "Per acabar";
                            }
                            echo '<option value="' . $llistatTasques[$i][$j]["id"] . '">' . $llistatTasques[$i][$j]["item"] . ' (' . $completed . ')</option>';
                        }
                    }
                    ?>
                </select>
                <br>
                <br>
                <label for="completedUpdate">Marca una opcio per modificar l'estat de la tasca:</label>
                <br>
                <input type="radio" name="completedUpdate" value="1">Acabada
                <br>
                <input type="radio" name="completedUpdate" value="0">Per acabar
                <br>
                <br>
                <button type="submit" class="crudTasks">Modifica</button>
            </form>
        </article>
        <article>
            <h4>Esborrar tasca</h4>
            <form action="\tasks\deleteTask" method="post">
                <label for="deleteTaskList">Selecciona una tasca:</label>
                <br>
                <select name="deleteTaskList">
                    <?php
                    for ($i = 0; $i < count($llistatTasques); $i++) {
                        for ($j = 0; $j < count($llistatTasques[$i]); $j++) {
                            if ($llistatTasques[$i][$j]["completed"]) {
                                $completed = "Acabada";
                            } else {
                                $completed = "Per acabar";
                            }
                            echo '<option value="' . $llistatTasques[$i][$j]["id"] . '">' . $llistatTasques[$i][$j]["item"] . ' (' . $completed . ')</option>';
                        }
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