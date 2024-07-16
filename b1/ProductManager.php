<?php
class ProductManager {
    private $pdo;

    public function __construct($host, $user, $password, $dbname) {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getProductById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM produits WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProducts() {
        $stmt = $this->pdo->query("SELECT * FROM produits");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProduct($nom, $prix, $quantite) {
        $date_ajout = date('Y-m-d H:i:s');
        $sql = "INSERT INTO produits (nom, prix, quantite, date_ajout, date_modification, photo)
                VALUES (?, ?, ?, ?, ?, '')";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nom, $prix, $quantite, $date_ajout, $date_ajout]);
    }

    public function updateQuantity($product_id, $new_quantity) {
        $date_modification = date('Y-m-d H:i:s');
        $sql = "UPDATE produits SET quantite = ?, date_modification = ? WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$new_quantity, $date_modification, $product_id]);
    }

    public function deleteProduct($product_id) {
        $sql = "DELETE FROM produits WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$product_id]);
    }
    public function updateProduct($id, $nom, $prix, $quantite) {
        $date_modification = date('Y-m-d H:i:s');
        $stmt = $this->pdo->prepare("UPDATE produits SET nom = ?, prix = ?, quantite = ?, date_modification = ? WHERE id = ?");
        $stmt->execute([$nom, $prix, $quantite, $date_modification, $id]);
    }
}
?>      
