<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ver Pokemones</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      background: url('img/Fondoapi.jpg') no-repeat center center fixed; 
      background-size: cover;
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 1200px;
      margin: 0 auto;
    }
    .pokemon-list {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }
    .pokemon-card {
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 10px;
      overflow: hidden;
      width: calc(20% - 20px);
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
      padding: 20px;
      cursor: pointer;
      transition: transform 0.2s;
    }
    .pokemon-card:hover {
      transform: scale(1.05);
    }
    .pokemon-card img {
      max-width: 100%;
      height: auto;
    }
    .pokemon-card h3 {
      margin: 10px 0;
      font-size: 18px;
    }
    .title {
      font-size: 32px;
      font-weight: bold;
      text-align: center;
      color: #333;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
      margin-bottom: 30px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="title">Mis Pokemones</h1>
    <div class="pokemon-list">
      <?php
      require 'Conexion.php';

      $conn = new mysqli($servername, $username, $password, $dbname);

      if ($conn->connect_error) {
          die("Conexión fallida: " . $conn->connect_error);
      }

      $sql = "SELECT id, name, image FROM pokemon";
      $result = $conn->query($sql);

      if ($result === false) {
          echo "<p>Error en la consulta: " . $conn->error . "</p>";
      } else {
          if ($result->num_rows > 0) {
              $counter = 1;
              while ($row = $result->fetch_assoc()) {
                  $id = htmlspecialchars($row['id']);
                  $name = htmlspecialchars($row['name']);
                  $image = htmlspecialchars($row['image']);
                  $imagePath = "uploads/" . $image;

                  echo "<a href='verpokedb.php?id=$id' class='pokemon-card'>";
                  echo "<h3>$counter. $name</h3>";
                  echo "<img src='$imagePath' alt='$name' />";
                  echo "</a>";
                  $counter++;
              }
          } else {
              echo "<p>No hay Pokémon en la base de datos.</p>";
          }
      }

      $conn->close();
      ?>
    </div>
  </div>
</body>
</html>
