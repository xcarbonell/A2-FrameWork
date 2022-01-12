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
            <h4>Llistes</h4>
            <br>
            <?php if ($teLlistes) : ?>
                <table>
                    <tr>
                        <th>Nom de la llista</th>
                    </tr>
                    <?php
                    for ($i = 0; $i < count($llistes); $i++) {
                        echo '<tr><td>' . $llistes[$i]['listName'] . '</td></tr>';
                    }
                    ?>
                </table>
            <?php else : ?>
                <p>No tens llistes de tasques</p>
            <?php endif ?>
        </article>
        <article>
            <h4>Crear llista de tasques</h4>
            <form action="\lists\createList" method="post">
                <label for="createListName">Introdueix el nom de la llista:</label>
                <input type="text" name="createListName" placeholder="Nom">
                <br>
                <br>
                <button type="submit" class="crudTasks">Crea llista</button>
            </form>
        </article>
        <article>
            <h4>Modificar llista</h4>
            <form action="\lists\updateList" method="post">
                <label for="updateList">Selecciona una llista:</label>
                <br>
                <select name="updateList">
                    <?php
                    for ($i = 0; $i < count($llistes); $i++) {
                        echo '<option value="' . $llistes[$i]["id"] . '">' . $llistes[$i]["listName"] . '</option>';
                    }
                    ?>
                </select>
                <br>
                <label for="updateListName">Introdueix el nou nom:</label>
                <input type="text" name="updateListName" placeholder="Nom">
                <br>
                <br>
                <button type="submit" class="crudTasks">Modifica</button>
            </form>
        </article>
        <article>
            <h4>Esborrar llista</h4>
            <form action="\lists\deleteList" method="post">
                <label for="deleteList">Selecciona una llista:</label>
                <br>
                <select name="deleteList">
                    <?php
                    for ($i = 0; $i < count($llistes); $i++) {
                        echo '<option value="' . $llistes[$i]["id"] . '">' . $llistes[$i]["listName"] . '</option>';
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