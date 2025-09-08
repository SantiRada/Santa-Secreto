<?php 

    // $con = mysqli_connect("localhost", "gamesdev_admin", "Mardel/2024", "gamesdev_games");
    $con = mysqli_connect("localhost", "root", "", "santa-secreto");
    mysqli_set_charset($con, "utf8mb4");

    $room = $_GET['room'] ?? 0;
    $player = $_GET['player'] ?? "";

    $search = "select * from santas where name = '".$player."' and id_room = '".$room."';";
    $resSearch = mysqli_query($con, $search);
    $rowSearch = mysqli_fetch_assoc($resSearch);

    if($rowSearch['goal'] == -1):
        $players = mysqli_query($con, "select * from santas where selected = 0 and id_room = '".$room."' order by name asc;");
    
        $id = 0;
        $playerFinal = "";
        $i = 0;
        do{
            $final = rand(0, (mysqli_num_rows($players) - 1));
            
            foreach($players as $pl):
                if($i == $final):
                    $id = $pl['id'];
                    $playerFinal = $pl['name'];
                    break;
                endif;
                $i++;
            endforeach;
        } while($playerFinal == "" || $playerFinal == $player);
    
        // Guarda a quién le tocó el PLAYER
        $newData = "update santas set goal = '".$id."', nameGoal = '".$playerFinal."' where name = '".$player."' and id_room = '".$room."';";
        mysqli_query($con, $newData);
    
        // GUARDA EL PLAYER YA SELECCIONADO
        $prevPlayer = "update santas set selected = 1 where id = '".$id."';";
        mysqli_query($con, $prevPlayer);
    endif;
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
    <div class="sector-logo roulette">
        <img class="logo" src="images/logo.png" alt="logo">
    </div>
    <?php if($rowSearch['goal'] != -1): ?>
        <h1 style="text-align: center;" class="santa">¡Ya eres <span>Santa Secreto</span> de</h1>
        
        <a class="final" href="#"><?php echo $rowSearch['nameGoal']; ?>!</a>
        <small>No hay devoluciones</small>
    <?php else: ?>
        <h1 class="santa">¡Eres <span>Santa Secreto</span> de ...</h1>
        <a class="final" href="#"><?php echo $playerFinal; ?>!</a>
        <small>No hay devoluciones</small>
    <?php endif; ?>
</body>
</html>