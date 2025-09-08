<?php
    $room = $_GET['room'] ?? "";

    // $con = mysqli_connect("localhost", "gamesdev_admin", "Mardel/2024", "gamesdev_games");
    $con = mysqli_connect("localhost", "root", "", "santa-secreto");
    mysqli_set_charset($con, "utf8mb4");

    $players = mysqli_query($con, "select * from santas where id_room = '".$room."' order by name asc;");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santa Secreto 2024</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jersey+25&display=swap" rel="stylesheet">
</head>
<body>
    <div class="sector-logo">
        <img class="logo" src="images/logo.png" alt="logo">
    </div>
    <?php if(mysqli_num_rows($players) > 0): ?>
        <h1>¿Quién eres? 👀</h1>
        <section id="user">
            <?php foreach($players as $goal): if($goal['goal'] != -1): ?>
                    <a class="cross-out"><?php echo $goal['name']; ?></a>
                <?php else: ?>
                    <a class="chip-user" href="roulette.php?player=<?php echo $goal['name']; ?>&room=<?php echo $room; ?>"><?php echo $goal['name']; ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </section>
    <?php else: ?>
        <h1 class="center">Esta sala no existe o<br><span>está vacía</span></h1>
        <a href="index.php" class="button">Volver</a>
    <?php endif; ?>
</body>
</html>