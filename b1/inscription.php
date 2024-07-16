<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté, le rediriger vers l'accueil s'il l'est
if (isset($_SESSION['username'])) {
    header("Location: home.php");
    exit();
}

// Initialisation des variables
$username = "";
$password = "";
$confirm_password = "";
$error_message = "";

// Connexion à la base de données
$host = 'localhost';
$dbname = 'pharmacie';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);

    // Validation basique
    if ($password != $confirm_password) {
        $error_message = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si le nom d'utilisateur existe déjà
        $stmt = $pdo->prepare("SELECT id FROM user WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            $error_message = "Le nom d'utilisateur est déjà pris.";
        } else {
            // Hacher le mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insérer l'utilisateur dans la base de données
            $stmt = $pdo->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
            if ($stmt->execute([$username, $hashed_password])) {
                // Connexion automatique après inscription
                $_SESSION['username'] = $username;
                header("Location: home.php");
                exit();
            } else {
                $error_message = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            width: 300px;
        }
        .register-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .register-container input[type="text"],
        .register-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .register-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .register-container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 20px;
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Créer un compte</h2>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Nom d'utilisateur" value="<?php echo htmlspecialchars($username); ?>" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required>
        <input type="submit" value="Créer un compte">
    </form>
    <?php if (!empty($error_message)) : ?>
        <p class="message"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <div class="login-link">
        <a href="index.php">Déjà un compte ? Connectez-vous ici</a>
    </div>
</div>

</body>
</html>
