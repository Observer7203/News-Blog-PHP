<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    public function show(string $slug): void
    {
        $article = Article::findBySlug($slug);

        if (!$article) {
            http_response_code(404);
            $this->render('pages/404.tpl');
            return;
        }

        Article::incrementViews($article['id']);
        $article['views']++;

        $categories = Article::getCategories($article['id']);
        $relatedArticles = Article::getRelated($article['id'], 3);

        $this->render('pages/article.tpl', [
            'article' => $article,
            'categories' => $categories,
            'related_articles' => $relatedArticles,
            'page_title' => $article['title']
        ]);
    }
}
