<?php
require 'conexion.php'; // llamamos la conexion

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$campaign = $_POST['campaign']; // agarramos la campaña 

if ($campaign === "delete") {
    // Verificar si la clave se ha enviado y si la clave proporcionada es correcta
    if (isset($_POST['password'])) {
        $claveIngresada = $_POST['password']; // Captura la clave ingresada en la alerta

        // Realizar una verificación de la clave aquí (compararla con la clave correcta)
        $claveCorrecta = "110428.O05"; 

        if ($claveIngresada === $claveCorrecta) {
            // Ejecutar la consulta DELETE para eliminar registros
            $sql = "DELETE FROM tokens";
            
            if ($conn->query($sql) === TRUE) {
                echo "success"; // Envía una respuesta de éxito al cliente
            } else {
                echo "Error al eliminar registros: " . $conn->error;
            }
        } else {
            echo "Clave incorrecta"; // Envía un mensaje de error al cliente
        }
    } else {
    }
} else {
    // Consulta para mostrar datos, no realiza eliminación aquí
    $sql = "SELECT * FROM oper_logistico WHERE operador = '$campaign' ORDER BY id DESC LIMIT 10";
    
    $result = $conn->query($sql);

    if ($result !== false) {
        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                echo "<tr scope='row'>";
                echo "<td>" . $fila['operador'] . "</td>";
                echo "<td>" . $fila['codigo'] . "</td>";
                echo "<td>" . $fila['fecha_hora'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No hay datos disponibles</td></tr>";
        }
    } else {
        echo "Error en la consulta: " . $conn->error;
    }
}

$conn->close();
