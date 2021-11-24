<?php require('partials/head.php'); ?>

    <h1>Home Page</h1>
    <?php foreach($roles as $role):?>
        <p><?php echo $role->role ;?></p>
    <?php endforeach; ?>

<?php require('partials/footer.php'); ?>
