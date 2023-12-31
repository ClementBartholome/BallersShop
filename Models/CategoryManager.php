<?php 

class CategoryManager extends Model {
    public function getCategories(): array {
        $query = "SELECT * FROM categories";
        $result = $this->executeRequest($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryIdByName(string $categoryName): ?int {
        $query = "SELECT id FROM categories WHERE name = :categoryName";
        $params = [':categoryName' => $categoryName];
        $result = $this->executeRequest($query, $params);
        
        $category = $result->fetch(PDO::FETCH_ASSOC);
        
        if ($category) {
            return $category['id'];
        } else {
            return null;
        }
    }

    public function addCategory(string $categoryName): int {
        $query = "INSERT INTO categories (name) VALUES (:categoryName)";
        $params = [':categoryName' => $categoryName];
        $this->executeRequest($query, $params);


        return $this->getCategoryIdByName($categoryName);
    }

    public function associateProductWithCategory(int $productId, int $categoryId): void {
        $query = "INSERT INTO categories_products (id, category_id, product_id) VALUES (:id, :categoryId, :productId)";
        $params = [
            ':id' => 0,
            ':categoryId' => $categoryId,
            ':productId' => $productId
        ];
        $this->executeRequest($query, $params);
    }
}