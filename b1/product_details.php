<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

require 'ProductManager.php';

$productManager = new ProductManager('localhost', getenv('DB_USER'), '', 'pharmacie');

// Vérifier si l'ID du produit est passé en paramètre
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $product = $productManager->getProductById($product_id);

    if (!$product) {
        die('Produit non trouvé.');
    }
} else {
    die('ID de produit non spécifié.');
}

// Traitement de la soumission du formulaire de mise à jour
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $prix = floatval($_POST['prix']);
    $quantite = intval($_POST['quantite']);

    $productManager->updateProduct($product_id, $nom, $prix, $quantite);

    // Redirection vers la page de gestion après la modification
    header("Location: gestion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Produit - Pharmacie</title>
    <style>
        /* Styles CSS pour l'interface de gestion */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        .detail-form {
            margin-top: 20px;
        }
        .detail-form input[type="text"],
        .detail-form input[type="number"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .detail-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .detail-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Détails du Produit - Pharmacie</h2>

    <!-- Formulaire pour afficher et modifier les détails du produit -->
    <form action="" method="post" class="detail-form">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <label for="nom">Nom du produit:</label>
        <input type="text" id="nom" name="nom" value="<?php echo $product['nom']; ?>" required>
        <label for="prix">Prix:</label>
        <input type="number" id="prix" name="prix" value="<?php echo $product['prix']; ?>" step="0.01" required>
        <label for="quantite">Quantité:</label>
        <input type="number" id="quantite" name="quantite" value="<?php echo $product['quantite']; ?>" required>
        <input type="submit" name="modifier" value="Modifier">
    </form>

</div>

</body>
</html>
