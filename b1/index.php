<?php
session_start();

// Connexion à la base de données
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérification des identifiants lorsque le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Préparer la requête pour vérifier les informations d'identification
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Identifiants valides, démarrer la session
        $_SESSION['username'] = $username;
        header("Location: home.php");
        exit();
    } else {
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 300px;
        }
        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .login-container .register-link {
            text-align: center;
            margin-top: 10px;
        }
        .login-container .register-link a {
            color: #4CAF50;
            text-decoration: none;
        }
        .login-container .register-link a:hover {
            text-decoration: underline;
        }
        .message {
            margin-top: 20px;
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Connexion</h2>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="submit" value="Se connecter">
    </form>
    <?php if (isset($error_message)) : ?>
        <p class="message"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <div class="register-link">
        <p>Vous n'avez pas de compte ? <a href="inscription.php">Créer un compte</a></p>
    </div>
</div>

</body>
</html>
