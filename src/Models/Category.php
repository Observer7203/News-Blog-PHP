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
}
