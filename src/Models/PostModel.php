<?php

namespace App\Models;

use App\Core\Model;

class PostModel extends Model
{
    private int $perPage = 12;

    public function getLatest(int $limit = 3): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM posts ORDER BY created_at DESC LIMIT :limit'
        );
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll();

        return $this->withCategories($posts);
    }

    public function getAll(int $page = 1): array
    {
        $offset = ($page - 1) * $this->perPage;
        $stmt = $this->db->prepare(
            'SELECT * FROM posts ORDER BY created_at DESC LIMIT :limit OFFSET :offset'
        );
        $stmt->bindValue(':limit', $this->perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll();

        return $this->withCategories($posts);
    }

    public function countAll(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM posts')->fetchColumn();
    }

    public function getBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM posts WHERE slug = :slug LIMIT 1');
        $stmt->execute(['slug' => $slug]);
        $result = $stmt->fetch();

        if ($result === false) {
            return null;
        }

        $result['categories'] = $this->getCategories($result['id']);

        return $result;
    }

    public function getByCategory(int $categoryId, int $page = 1, ?int $limit = null): array
    {
        $offset = ($page - 1) * $this->perPage;
        $stmt = $this->db->prepare(
            'SELECT a.* FROM posts a
             JOIN post_category ac ON a.id = ac.post_id
             WHERE ac.category_id = :category_id
             ORDER BY a.created_at DESC
             LIMIT :limit OFFSET :offset'
        );
        $stmt->bindValue(':category_id', $categoryId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit ?? $this->perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll();

        return $this->withCategories($posts);
    }

    public function countByCategory(int $categoryId): int
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM post_category WHERE category_id = :category_id'
        );
        $stmt->execute(['category_id' => $categoryId]);
        return (int) $stmt->fetchColumn();
    }

    public function getCategories(int $postId): array
    {
        $stmt = $this->db->prepare(
            'SELECT c.* FROM categories c
             JOIN post_category ac ON c.id = ac.category_id
             WHERE ac.post_id = :post_id'
        );
        $stmt->execute(['post_id' => $postId]);
        return $stmt->fetchAll();
    }

    public function incrementViews(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE posts SET views = views + 1 WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function getRandomSlug(): ?string
    {
        $result = $this->db->query('SELECT slug FROM posts ORDER BY RAND() LIMIT 1')->fetch();
        return $result ? $result['slug'] : null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO posts (title, slug, image, description, text)
             VALUES (:title, :slug, :image, :description, :text)'
        );
        $stmt->execute([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'image' => $data['image'] ?? null,
            'description' => $data['description'] ?? null,
            'text' => $data['text'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function attachCategory(int $postId, int $categoryId): void
    {
        $stmt = $this->db->prepare(
            'INSERT IGNORE INTO post_category (post_id, category_id) VALUES (:post_id, :category_id)'
        );
        $stmt->execute(['post_id' => $postId, 'category_id' => $categoryId]);
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    private function withCategories(array $posts): array
    {
        foreach ($posts as &$post) {
            $post['categories'] = $this->getCategories($post['id']);
        }
        return $posts;
    }
}
