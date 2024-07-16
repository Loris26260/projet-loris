<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

require 'ProductManager.php';
$productManager = new ProductManager('localhost', 'root', '', 'pharmacie');

// Traitement pour ajouter un nouveau produit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajouter'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $prix = floatval($_POST['prix']);
    $quantite = intval($_POST['quantite']);

    $productManager->addProduct($nom, $prix, $quantite);

    // Redirection vers la page de gestion
    header("Location: gestion.php");
    exit();
}

// Traitement pour mettre à jour la quantité d'un produit existant
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
    $product_id = intval($_POST['product_id']);
    $new_quantity = intval($_POST['new_quantity']);

    $productManager->updateQuantity($product_id, $new_quantity);

    echo "Quantité mise à jour avec succès.";
}

// Traitement pour supprimer un produit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supprimer'])) {
    $product_id = intval($_POST['product_id']);

    $productManager->deleteProduct($product_id);

    echo "Produit supprimé avec succès.";
}

$products = $productManager->getProducts();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits - Pharmacie</title>
    <style>
        /* Styles CSS pour l'interface de gestion */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td img {
            max-width: 100px;
            max-height: 100px;
        }
        .add-form {
            margin-top: 20px;
        }
        .add-form input[type="text"],
        .add-form input[type="number"],
        .add-form input[type="date"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .add-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .add-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        // JavaScript pour la mise à jour en temps réel de la quantité
        function updateQuantity(productId, currentQuantity) {
            var newQuantity = prompt("Entrez la nouvelle quantité :", currentQuantity);
            if (newQuantity !== null && !isNaN(newQuantity)) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "gestion.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        window.location.reload();
                    }
                };
                var params = "modifier=true&product_id=" + productId + "&new_quantity=" + newQuantity;
                xhr.send(params);
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Gestion des Produits - Pharmacie</h2>

    <!-- Formulaire pour ajouter un nouveau produit -->
    <form action="" method="post" class="add-form">
        <h3>Ajouter un Nouveau Produit</h3>
        <input type="text" name="nom" placeholder="Nom du produit" required>
        <input type="number" name="prix" placeholder="Prix" step="0.01" required>
        <input type="number" name="quantite" placeholder="Quantité" required>
        <input type="submit" name="ajouter" value="Ajouter">
        <?php if (isset($error_message)) : ?>
            <p><?php echo $error_message; ?></p>
        <?php endif; ?>
    </form>

    <!-- Tableau des produits avec possibilité de modification et suppression -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom du Produit</th>
                <th>Prix en €</th>
                <th>Quantité</th>
                <th>Date d'Ajout</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><a href="product_details.php?id=<?php echo $product['id']; ?>"><?php echo $product['nom']; ?></a></td>
                    <td><?php echo $product['prix']; ?></td>
                    <td>
                        <span id="quantity_<?php echo $product['id']; ?>"><?php echo $product['quantite']; ?></span>
                        <button onclick="updateQuantity(<?php echo $product['id']; ?>, <?php echo $product['quantite']; ?>)">
                            Modifier Quantité
                        </button>
                    </td>
                    <td><?php echo $product['date_ajout']; ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="submit" name="supprimer" value="Supprimer">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>
