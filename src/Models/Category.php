<?php

namespace App\Models;

use App\Core\Database;

class Category
{
    public static function all(): array
    {
        return Database::fetchAll('SELECT * FROM categories ORDER BY name ASC');
    }

    public static function find(int $id): ?array
    {
        return Database::fetch('SELECT * FROM categories WHERE id = ?', [$id]);
    }

    public static function findBySlug(string $slug): ?array
    {
        return Database::fetch('SELECT * FROM categories WHERE slug = ?', [$slug]);
    }

    public static function withArticles(): array
    {
        $categories = self::all();

        foreach ($categories as &$category) {
            $category['articles'] = Article::getByCategoryId($category['id'], 3);
            $category['article_count'] = Article::countByCategory($category['id']);
        }

        return array_filter($categories, fn($cat) => $cat['article_count'] > 0);
    }

    public static function create(array $data): int
    {
        Database::query(
            'INSERT INTO categories (name, slug, description, created_at) VALUES (?, ?, ?, NOW())',
            [$data['name'], $data['slug'], $data['description'] ?? null]
        );

        return (int)Database::lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        Database::query(
            'UPDATE categories SET name = ?, slug = ?, description = ? WHERE id = ?',
            [$data['name'], $data['slug'], $data['description'] ?? null, $id]
        );
    }

    public static function delete(int $id): void
    {
        Database::query('DELETE FROM categories WHERE id = ?', [$id]);
    }

    public static function count(): int
    {
        $result = Database::fetch('SELECT COUNT(*) as count FROM categories');
        return (int)($result['count'] ?? 0);
    }

    public static function deleteAll(): void
    {
        Database::query('DELETE FROM article_category');
        Database::query('DELETE FROM categories');
    }
}
