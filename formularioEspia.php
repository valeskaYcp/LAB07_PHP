<?php

session_start();

// Database connection
$pdo = new PDO(
    'mysql:host=localhost;dbname=formularioespia', 'root', '');

// Función para validar la entrada de datos y evitar XSS
function validateInput($data) {
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y limpiar los datos ingresados
    $nombre = validateInput($_POST['nombre']);
    $agenteID = validateInput($_POST['agenteID']);
    $departamentoID = validateInput($_POST['departamentoID']);
    $numMisiones = validateInput($_POST['numMisiones']);
    $descripcionMision = validateInput($_POST['descripcionMision']);
    $fecha_mision = validateInput($_POST['fecha_mision']); // Corregido aquí
    $habilidad = validateInput($_POST['habilidad']);
    // Se encriptan los datos por seguridad
    $nombreEncriptado = base64_encode($nombre);
    $agenteIDEncriptado = base64_encode($agenteID);
    $descripcionMisionEncriptada = base64_encode($descripcionMision);


    // Insertar los datos en la base de datos
    $sql = "INSERT INTO espia (nombre, agente_id, departamento_id, num_misiones, descripcion_mision, fecha_mision, habilidad)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$nombreEncriptado, $agenteIDEncriptado, $departamentoID, $numMisiones, $descripcionMisionEncriptada, $fecha_mision, $habilidad])) {
        // Establecer la sesión agente_secreto
        $_SESSION['agente_secreto'] = [
            'nombre' => $nombreEncriptado,
            'agenteID' => $agenteIDEncriptado,
            'departamentoID' => $departamentoID,
            'numMisiones' => $numMisiones,
            'descripcionMision' => $descripcionMisionEncriptada,
            'fecha_mision' => $fecha_mision,
            'habilidad' => $habilidad,
        ];
        // Se refirije a una página de confirmación 
        header("Location: confirmacion.php");
        exit();
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "Error: " . $errorInfo[2];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Agente Secreto</title>
    <style>
        body {
            font-family: "Cambria Math", sans-serif;
            background-color: #645f5f;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
            text-align: center;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        textarea,
        input[type="date"] {
            width: 100% ;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: "Cambria Math", sans-serif;
        }
        input[type="submit"] {
            background-color: #000000;
            font-family: 'Cambria Math', sans-serif; 
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 20px;
        }
        input[type="submit"]:hover {
            font-family: 'Cambria Math', sans-serif; 
            background-color: #505255;
        }
</style>
</head>
<body>
    <div class="container">
        <h2>Ingrese los datos del Agente Secreto</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre"><br>
            <label for="agenteID">Agente ID:</label><br>
            <input type="text" id="agenteID" name="agenteID"><br>
            <label for="departamentoID">Departamento ID:</label><br>
            <input type="text" id="departamentoID" name="departamentoID"><br>
            <label for="numMisiones">Número de misiones:</label><br>
            <input type="number" id="numMisiones" name="numMisiones" min="0"><br>
            <label for="descripcionMision">Descripción de la nueva misión:</label><br>
            <textarea id="descripcionMision" name="descripcionMision"></textarea><br>
            <label for="fecha_mision">Fecha de Misión:</label><br>
            <input type="date" id="fecha_mision" name="fecha_mision" value="<?php echo date('Y-m-d'); ?>"><br>
            <label for="habilidad">Habilidad:</label><br>
            <input type="text" id="habilidad" name="habilidad"><br>
            <input type="submit" value="Enviar Datos">
        </form>
    </div>

</body>
</html>

CREATE TABLE espia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    agente_id VARCHAR(50) NOT NULL,
    departamento_id INT NOT NULL,
    num_misiones INT NOT NULL,
    descripcion_mision TEXT NOT NULL,
    fecha_mision DATE NOT NULL,
    habilidades VARCHAR(50) NOT NULL
);
