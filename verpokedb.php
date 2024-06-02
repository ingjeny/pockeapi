<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalle Pokémon</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 1200px;
      margin: 0 auto;
    }
    .pokemon-details {
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    .pokemon-details img {
      max-width: 100%;
      height: auto;
    }
    .pokemon-details h3 {
      margin: 10px 0;
      font-size: 24px;
    }
    .pokemon-details p {
      font-size: 18px;
      margin: 5px 0;
    }
    .pokemon-details .btn {
      margin: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php
    if (isset($_GET['id'])) {
        require 'Conexion.php';

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $id = intval($_GET['id']);
        $sql = "SELECT name, type, moves, image FROM pokemon WHERE id = $id";
        $result = $conn->query($sql);

        if ($result === false) {
            echo "<p>Error en la consulta: " . $conn->error . "</p>";
        } else {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $name = htmlspecialchars($row['name']);
                $type = json_decode($row['type']);
                $moves = json_decode($row['moves']);
                $image = htmlspecialchars($row['image']);
                $imagePath = "uploads/" . $image;

                if (!is_array($type)) {
                    $type = [];
                }
                if (!is_array($moves)) {
                    $moves = [];
                }

                echo "<div class='pokemon-details'>";
                echo "<h3>$name</h3>";
                echo "<img src='$imagePath' alt='$name' />";
                echo "<p><strong>Tipo:</strong> " . implode(', ', $type) . "</p>";
                echo "<p><strong>Habilidadess:</strong> " . implode(', ', $moves) . "</p>";
                echo "<a href='editar.php?id=$id' class='btn btn-primary'>Editar</a>";
                echo "<a href='eliminarpokemon.php?id=$id' class='btn btn-danger'>Eliminar</a>";
                echo "</div>";
            } else {
                echo "<p>No se encontró el Pokémon.</p>";
            }
        }

        $conn->close();
    } else {
        echo "<p>ID del Pokémon no especificado.</p>";
    }
    ?>
  </div>
</body>
</html>
