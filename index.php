<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tokens</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="shortcut icon" href="./img/logo-removebg-preview.ico" type="image/x-icon">
    <link rel="stylesheet" href="./estilos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <!--- conexion base de datos --->
    <?php
        require './php/conexion.php';

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta para obtener los datos
        $sql = "SELECT * FROM tokens ORDER BY id DESC LIMIT 10";
        $result = $conn->query($sql);
        $conn->close();
    ?>

    <!--- contenedor --->
    <div class="container">
        <h1>Tokens</h1>
        <!--- botones --->
        <div class="btn">
            <button data-campaign="Esm">Esm</button>
            <button data-campaign="ojt_d">OJT_D</button>
            <button data-campaign="movil">MOVIL</button>
            <button data-campaign="portabilidad">PORTABILIDAD</button>
            <button data-campaign="migracion">MIGRACIÓN</button>
            <button data-campaign="Cali Express">Cali Express</button>
            <button data-campaign="Integra">Integra</button>
            <button data-campaign="back">BACKOFFICE</button>
            <button data-campaign="usuarios">usuario</button>
            <button data-campaign="delete" id="deleteButton">ELIMINAR</button>
        </div>

        <!--- tabla --->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Campaña</th>
                    <th scope="col">Codigo</th>
                    <th scope="col">Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $result->fetch_assoc()) { ?>
                    <tr scope="row">
                        <td><?php echo $fila['campaña']; ?></td>
                        <td><?php echo $fila['codigo']; ?></td>
                        <td><?php echo $fila['hora']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>