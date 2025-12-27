<?php

namespace App\Models;

use App\Core\Database;

class Article
{
    public static function all(string $orderBy = 'created_at', string $direction = 'DESC'): array
    {
        $allowedColumns = ['created_at', 'views', 'title'];
        $orderBy = in_array($orderBy, $allowedColumns) ? $orderBy : 'created_at';
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        return Database::fetchAll("SELECT * FROM articles ORDER BY {$orderBy} {$direction}");
    }

    public static function find(int $id): ?array
    {
        return Database::fetch('SELECT * FROM articles WHERE id = ?', [$id]);
    }

    public static function findBySlug(string $slug): ?array
    {
        return Database::fetch('SELECT * FROM articles WHERE slug = ?', [$slug]);
    }

    public static function getByCategoryId(
        int $categoryId,
        int $limit = 9,
        int $offset = 0,
        string $orderBy = 'created_at',
        string $direction = 'DESC'
    ): array {
        $allowedColumns = ['created_at', 'views', 'title'];
        $orderBy = in_array($orderBy, $allowedColumns) ? $orderBy : 'created_at';
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        return Database::fetchAll(
            "SELECT a.* FROM articles a
             INNER JOIN article_category ac ON a.id = ac.article_id
             WHERE ac.category_id = ?
             ORDER BY a.{$orderBy} {$direction}
             LIMIT ? OFFSET ?",
            [$categoryId, $limit, $offset]
        );
    }

    public static function countByCategory(int $categoryId): int
    {
        $result = Database::fetch(
            'SELECT COUNT(*) as count FROM article_category WHERE category_id = ?',
            [$categoryId]
        );
        return (int)($result['count'] ?? 0);
    }

    public static function incrementViews(int $id): void
    {
        Database::query('UPDATE articles SET views = views + 1 WHERE id = ?', [$id]);
    }

    public static function getRelated(int $articleId, int $limit = 3): array
    {
        return Database::fetchAll(
            "SELECT DISTINCT a.* FROM articles a
             INNER JOIN article_category ac1 ON a.id = ac1.article_id
             INNER JOIN article_category ac2 ON ac1.category_id = ac2.category_id
             WHERE ac2.article_id = ? AND a.id != ?
             ORDER BY a.created_at DESC
             LIMIT ?",
            [$articleId, $articleId, $limit]
        );
    }

    public static function getCategories(int $articleId): array
    {
        return Database::fetchAll(
            "SELECT c.* FROM categories c
             INNER JOIN article_category ac ON c.id = ac.category_id
             WHERE ac.article_id = ?",
            [$articleId]
        );
    }

    public static function create(array $data): int
    {
        Database::query(
            'INSERT INTO articles (title, slug, description, content, image, views, created_at)
             VALUES (?, ?, ?, ?, ?, 0, NOW())',
            [
                $data['title'],
                $data['slug'],
                $data['description'],
                $data['content'],
                $data['image'] ?? null
            ]
        );

        return (int)Database::lastInsertId();
    }

    public static function attachCategory(int $articleId, int $categoryId): void
    {
        Database::query(
            'INSERT IGNORE INTO article_category (article_id, category_id) VALUES (?, ?)',
            [$articleId, $categoryId]
        );
    }

    public static function update(int $id, array $data): void
    {
        Database::query(
            'UPDATE articles SET title = ?, slug = ?, description = ?, content = ?, image = ? WHERE id = ?',
            [
                $data['title'],
                $data['slug'],
                $data['description'],
                $data['content'],
                $data['image'] ?? null,
                $id
            ]
        );
    }

    public static function delete(int $id): void
    {
        Database::query('DELETE FROM article_category WHERE article_id = ?', [$id]);
        Database::query('DELETE FROM articles WHERE id = ?', [$id]);
    }

    public static function syncCategories(int $articleId, array $categoryIds): void
    {
        Database::query('DELETE FROM article_category WHERE article_id = ?', [$articleId]);
        foreach ($categoryIds as $categoryId) {
            self::attachCategory($articleId, (int)$categoryId);
        }
    }

    public static function count(): int
    {
        $result = Database::fetch('SELECT COUNT(*) as count FROM articles');
        return (int)($result['count'] ?? 0);
    }

    public static function deleteAll(): void
    {
        Database::query('DELETE FROM article_category');
        Database::query('DELETE FROM articles');
    }

    public static function getCategoryIds(int $articleId): array
    {
        $rows = Database::fetchAll(
            'SELECT category_id FROM article_category WHERE article_id = ?',
            [$articleId]
        );
        return array_column($rows, 'category_id');
    }
}
