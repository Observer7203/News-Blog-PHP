<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;
use App\Models\Article;

class CategoryController extends Controller
{
    public function show(string $slug): void
    {
        $category = Category::findBySlug($slug);

        if (!$category) {
            http_response_code(404);
            $this->render('pages/404.tpl');
            return;
        }

        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 9;
        $orderBy = $_GET['sort'] ?? 'created_at';
        $direction = $_GET['dir'] ?? 'DESC';

        $totalArticles = Article::countByCategory($category['id']);
        $totalPages = ceil($totalArticles / $perPage);
        $offset = ($page - 1) * $perPage;

        $articles = Article::getByCategoryId(
            $category['id'],
            $perPage,
            $offset,
            $orderBy,
            $direction
        );

        $this->render('pages/category.tpl', [
            'category' => $category,
            'articles' => $articles,
            'page_title' => $category['name'],
            'pagination' => [
                'current' => $page,
                'total' => $totalPages,
                'per_page' => $perPage,
                'total_items' => $totalArticles
            ],
            'sort' => $orderBy,
            'dir' => $direction
        ]);
    }
}
