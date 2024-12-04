<?php


class CProducts{
    public $db;

    public function __construct(){
        $this->db = new PDO("mysql:host=localhost;dbname=products",'root','');

    }
    public function getProducts(){
        $stmt = $this->db->query("SELECT * FROM products2 LIMIT 10");
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }
    public function getProductsByDateDesc(){
        $stmt = $this->db->query("SELECT * FROM products2 ORDER BY DATE_CREATE DESC");
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public function Hidden($productId){
        $stmt = $this->db->prepare("UPDATE products2 SET hidden = 1 WHERE id = ?");
        return $stmt->execute( [$productId] );
    }

    public function increment($productId, $increment){
        $stmt = $this->db->prepare('UPDATE products2 SET PRODUCT_QUANTITY = :increment WHERE ID = :productId');
        return $stmt->execute([':increment' => $increment,':productId' => $productId]);
        
}
    public function dicrement($productId, $dicrement){
        $stmt = $this->db->prepare('UPDATE products2 SET PRODUCT_QUANTITY = :dicrement WHERE ID = :productId');
        return $stmt->execute([':dicrement' => $dicrement,':productId' => $productId]);

    }
}