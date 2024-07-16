<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .welcome {
            text-align: center;
            margin-bottom: 20px;
        }
        .menu {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .menu a {
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .menu a:hover {
            background-color: #45a049;
        }
        .action-button {
            padding: 15px 30px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s;
        }
        .action-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="welcome">
        <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> !</h2>
        <p>Connecter</p>
    </div>
    
    <div class="menu">
        <a href="#">Accueil</a>
        <a href="#">Profil</a>
        <a href="#">Paramètres</a>
        <a href="gestion.php" class="action-button">Gestion</a>
        <a href="logout.php">Déconnexion</a>
    </div>
</div>

</body>
</html>
