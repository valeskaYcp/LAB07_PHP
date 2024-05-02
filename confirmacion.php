<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos del Agente Secreto</title>
    <style>
            body {
            font-family: 'Cambria Math', sans-serif;
            background-color: #2b2828;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto 100px; 
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            font-size: 32px;
            text-align: left;
            margin-bottom: 20px; 
        }

        p {
            margin: 5px 0;
            text-align: left;
        }

        strong {
            font-weight: bold;
        }

        .btn {
            background-color: #000000;
            font-family: 'Cambria Math', sans-serif; 
            font-size: 20px;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px; 
        }

        .btn:hover {
            font-family: 'Cambria Math', sans-serif; 
            background-color: #525457;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        session_start();

        // Verificar si existe la sesión
        if (isset($_SESSION['agente_secreto'])) {
            // Se muestran los datos del agente secreto
            $agenteSecreto = $_SESSION['agente_secreto'];

            // Desencriptar los campos necesarios
            $nombreDesencriptado = base64_decode($agenteSecreto['nombre']);
            $descripcionMisionDesencriptada = base64_decode($agenteSecreto['descripcionMision']);
            $agenteIDDesencriptada = base64_decode($agenteSecreto['agenteID']);

            // Mostrar los datos del agente secreto
            echo "<h2>Datos del Agente Secreto</h2>";
            echo "<p><strong>Nombre:</strong> $nombreDesencriptado</p>";
            echo "<p><strong>Agente ID:</strong> $agenteIDDesencriptada</p>";
            echo "<p><strong>Departamento ID:</strong> {$agenteSecreto['departamentoID']}</p>";
            echo "<p><strong>Número de misiones:</strong> {$agenteSecreto['numMisiones']}</p>";
            echo "<p><strong>Descripción de la nueva misión:</strong> $descripcionMisionDesencriptada</p>";
            echo "<p><strong>Fecha de la misión:</strong> {$agenteSecreto['fecha_mision']}</p>";
            echo "<p><strong>Habilidades:</strong> {$agenteSecreto['habilidad']}</p>";

            // Limpiar y destruir la sesión
            unset($_SESSION['agente_secreto']);
            session_destroy();
        } else {
            // Si no existe la sesión, redirigir al formulario
            header("Location: formularioEspia.php");
            exit();
        }
        ?>
        <button class="btn" onclick="location.href='formularioEspia.php'">Volver a Ingresar Datos</button>
    </div>
</body>
</html>



