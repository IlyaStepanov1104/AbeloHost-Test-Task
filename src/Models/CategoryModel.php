<?php

namespace App\Models;

use App\Core\Model;

class CategoryModel extends Model
{
    public function getAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM categories ORDER BY name ASC');
        return $stmt->fetchAll();
    }

    public function getAllWithPosts(int $postsLimit = 3): array
    {
        $categories = $this->getAll();
        $postModel = new PostModel();

        foreach ($categories as &$category) {
            $category['posts'] = $postModel->getByCategory($category['id'], 1, $postsLimit);
        }

        return $categories;
    }

    public function getBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE slug = :slug LIMIT 1');
        $stmt->execute(['slug' => $slug]);
        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }
}
