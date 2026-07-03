<?php

    if(isset($_GET['room'])): header('Location: room.php?id=' . $_GET['room']);     endif;

    $dir = $_GET['dir'] ?? "";

    $con = mysqli_connect("localhost", "u391462009_santiagorada", "SantiagoRada/2026", "u391462009_santiagorada");
    // $con = mysqli_connect("localhost", "root", "", "santa-secreto");
    mysqli_set_charset($con, "utf8mb4");

    if(isset($_POST['create'])):
        $content = $_POST['content'] ?? "";
        $players = explode(',', $content);

        $searchroom = "select * from ss_santas order by id desc limit 1;";
        $resSearch = mysqli_query($con, $searchroom);
        $rowSearch = mysqli_fetch_assoc($resSearch);
        $id = $rowSearch['id_room'] + 1;

        for($i = 0; $i < count($players); $i++):
            $newroom = "insert into ss_santas (id_room, name, goal, selected) values ('".$id."','".$players[$i]."','-1', '0');";
            $sendRoom = mysqli_query($con, $newroom);
        endfor;

        header('Location: index.php?dir=send&id=' . $id);
    endif;

    if(isset($_POST['select-room'])):
        $value = $_POST['value-select'] ?? "";

        header('Location: room.php?room=' . $value);
    endif;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santa Secreto 2026</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jersey+25&display=swap" rel="stylesheet">
</head>
<body>
    <div class="sector-logo">
        <img class="logo" src="images/logo.png" alt="logo">
    </div>
    <?php if($dir == "create-room"): ?>
        <form method="POST">
            <h3>Separa cada nombre por una coma sin dejar espacios.</h3>
            <textarea class="chip-input" placeholder="¿Quienes juegan?" name="content"></textarea>
            <input type="submit" class="button" value="Crear Sala" name="create" />
        </form>
    <?php elseif($dir == "select-room"): ?>
        <form method="post">
            <input type="number" placeholder="Número de Sala" class="chip-input" name="value-select" />
            <input type="submit" value="Seleccionar" name="select-room" class="button" />
        </form>
    <?php elseif($dir == "send"): ?>
        <h3 class="center-data">¡Ya puedes enviarle este link a todos los jugadores!</h3>
        <textarea disabled id="content-copy" class="chip-input">https://santiagorada.com/santa-secreto/index.php?room=<?php echo $_GET['id']; ?></textarea>
        <button onclick="copyToClipboard()" class="button">Copiar</button>
    <?php else: ?>
        <a href="index.php?dir=create-room" class="chip-user chip">Crear nueva sala</a>
        <a href="index.php?dir=select-room" class="chip-user chip">Ingresar a una sala</a>
    <?php endif; ?>

    <script>
        function copyToClipboard() {
            const element = document.getElementById('content-copy').value;

            navigator.clipboard.writeText(element)
                .then(() => {
                    console.log("¡Texto copiado al portapapeles!");
                })
                .catch(err => {
                    console.error("Error al copiar al portapapeles: ", err);
                });
                }
    </script>
</body>
</html>