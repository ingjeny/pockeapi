<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Result</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 800px;
      margin: 0 auto;
      text-align: center;
    }
    .back-button {
      display: inline-block;
      margin-bottom: 20px;
      padding: 10px 20px;
      font-size: 16px;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
    .back-button:hover {
      background-color: #0056b3;
    }
    .search-result {
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      padding: 20px;
      margin-top: 20px;
    }
    .search-result img {
      max-width: 100%;
      height: auto;
    }
    .search-result h1 {
      font-size: 24px;
      margin: 10px 0;
    }
    .moves {
      margin-top: 20px;
      text-align: left;
    }
    .moves h2 {
      font-size: 20px;
      margin-bottom: 10px;
    }
    .move {
      font-size: 16px;
      margin: 5px 0;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Back button -->
    <a class="back-button" href="index.php">Back</a>

    <div class="search-result">
<?php
$search_input = '';

if (isset($_POST['search_input']) && !empty($_POST['search_input'])) {
  $search_input = strtolower(trim($_POST['search_input']));
} elseif (isset($_GET['name']) && !empty($_GET['name'])) {
  $search_input = strtolower(trim($_GET['name']));
}

if (!empty($search_input)) {
  echo "<p>You searched for: <strong>$search_input</strong></p>";

  $poke_api_url = "https://pokeapi.co/api/v2/pokemon/" . $search_input;

  // Leer datos JSON
  $json_data = @file_get_contents($poke_api_url);

  // Decodificar datos JSON en un array de PHP
  $response_data = json_decode($json_data);

  if ($response_data && property_exists($response_data, 'name')) {
    // Almacenar datos del Pokémon en variables
    $name = $response_data->name;
    $image_url = $response_data->sprites->front_default;
    echo "<h1>$name</h1>";
    echo "<img src='$image_url' alt='$name' />";
    
    $moves = $response_data->moves;
    $moves = array_slice($moves, 0, 8); // Mostrar solo los primeros 8 movimientos

    echo "<div class='moves'>";
    echo "<h2>Moves:</h2>";
    foreach ($moves as $move) {
      $move_name = $move->move->name;
      echo "<div class='move'>$move_name</div>";
    }
    echo "</div>";
  } else {
    echo "<h2>No Pokémon found with the name \"$search_input\"</h2>";
  }
} else {
  echo "<h2>No search input provided.</h2>";
}
?>
    </div>
  </div>
</body>
</html>
