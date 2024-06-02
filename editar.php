<?php
// Incluir el archivo de conexión
require 'Conexion.php';

// Verificar si se ha pasado un ID a través de la URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Crear conexión usando la clase mysqli
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Preparar la consulta para obtener los datos del Pokémon a editar
    $sql = "SELECT * FROM pokemon WHERE id = ?";
    
    // Preparar la declaración
    if ($stmt = $conn->prepare($sql)) {
        // Enlazar parámetros
        $stmt->bind_param("i", $id);
        
        // Ejecutar la declaración
        if ($stmt->execute()) {
            // Obtener el resultado de la consulta
            $result = $stmt->get_result();
            
            // Verificar si se encontró un Pokémon con el ID especificado
            if ($result->num_rows === 1) {
                // Obtener los datos del Pokémon
                $pokemon = $result->fetch_assoc();
            } else {
                echo "No se encontró el Pokémon con el ID especificado.";
                exit();
            }
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
            exit();
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
        exit();
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "ID del Pokémon no especificado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Pokémon</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('img/Fondoapi.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-container {
      background: rgba(255, 255, 255, 0.8);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 400px;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    label {
      font-weight: bold;
      margin-top: 10px;
    }

    input[type="text"],
    input[type="file"],
    select {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ddd;
      margin-top: 5px;
      margin-bottom: 10px;
    }

    .btn-submit,
    .btn-view {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
      text-align: center;
      margin-top: 10px;
    }

    .btn-submit {
      background-color: #28a745;
      color: white;
    }

    .btn-submit:hover {
      background-color: #218838;
    }

    .btn-view {
      background-color: #007bff;
      color: white;
    }

    .btn-view:hover {
      background-color: #0056b3;
    }

    .success-message {
      display: none;
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 20px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container form-container">
    <h2>Editar Pokémon</h2>
    <div id="success-message" class="success-message">Pokémon actualizado con éxito</div>
    <form action="actualizarpokemon.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $pokemon['id']; ?>">

      <div class="form-group">
        <label for="name" class="form-label">Nombre:</label>
        <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($pokemon['name']); ?>">
      </div>

      <div class="form-group">
        <label for="type" class="form-label">Tipo:</label>
        <select id="type" name="type[]" multiple class="form-control">
          <?php
          $types = ["Normal", "Lucha", "Volador", "Veneno", "Tierra", "Roca", "Bicho", "Fantasma", "Acero", "Fuego", "Agua", "Hierba", "Eléctrico", "Psíquico", "Hielo", "Dragón", "Siniestro", "Hada", "Desconocido"];
          $selectedTypes = json_decode($pokemon['type'], true);
          foreach ($types as $type) {
            $selected = in_array($type, $selectedTypes) ? 'selected' : '';
            echo "<option value=\"$type\" $selected>$type</option>";
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="moves" class="form-label">Movimientos:</label>
        <select id="moves" name="moves[]" multiple class="form-control">
          <?php
          $moves = ["Hediondez", "Llovizna", "Aumento de Velocidad", "Armadura Batalla", "Robustez", "Humedad", "Ágil", "Velo Arena", "Electricidad Estática", "Absorbe Voltio", "Absorbe Agua", "Ajeno", "Cielonube", "Ojos Compuestos", "Insomnio", "Cambio Color", "Inmunidad", "Fuego Flash", "Escudo Polvo", "Marcha Propia"];
          $selectedMoves = json_decode($pokemon['moves'], true);
          foreach ($moves as $move) {
            $selected = in_array($move, $selectedMoves) ? 'selected' : '';
            echo "<option value=\"$move\" $selected>$move</option>";
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="image" class="form-label">Imagen:</label>
        <input type="file" id="image" name="image" class="form-control-file">
        <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($pokemon['image']); ?>">
      </div>

      <button type="submit" class="btn btn-submit">Actualizar Pokémon</button>
    </form>
    <a href="index.php" class="btn btn-view">Ver Pokemones</a>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('updated') && urlParams.get('updated') === 'true') {
        const successMessage = document.getElementById('success-message');
        successMessage.style.display = 'block';
        setTimeout(() => {
          successMessage.style.display = 'none';
        }, 3000); // El mensaje desaparecerá después de 3 segundos
      }
    });
  </script>
</body>
</html>
