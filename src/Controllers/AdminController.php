<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Database;
use App\Models\Category;
use App\Models\Article;

class AdminController extends Controller
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login(): void
    {
        if (Auth::check()) {
            $this->redirect('/admin');
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (Auth::attempt($username, $password)) {
                $this->redirect('/admin');
            } else {
                $error = 'Invalid credentials';
            }
        }

        $this->render('admin/login.tpl', [
            'error' => $error,
            'page_title' => 'Admin Login'
        ]);
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/admin/login');
    }

    public function dashboard(): void
    {
        Auth::requireAuth();

        $this->render('admin/dashboard.tpl', [
            'page_title' => 'Dashboard',
            'categories_count' => Category::count(),
            'articles_count' => Article::count()
        ]);
    }

    // Categories
    public function categories(): void
    {
        Auth::requireAuth();

        $this->render('admin/categories/index.tpl', [
            'page_title' => 'Categories',
            'categories' => Category::all()
        ]);
    }

    public function createCategory(): void
    {
        Auth::requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $slug = trim($_POST['slug'] ?? '') ?: $this->slugify($name);
            $description = trim($_POST['description'] ?? '');

            if ($name) {
                Category::create([
                    'name' => $name,
                    'slug' => $slug,
                    'description' => $description
                ]);
                $this->redirect('/admin/categories');
            }
        }

        $this->render('admin/categories/form.tpl', [
            'page_title' => 'Create Category',
            'category' => null
        ]);
    }

    public function editCategory(string $id): void
    {
        Auth::requireAuth();

        $category = Category::find((int)$id);
        if (!$category) {
            $this->redirect('/admin/categories');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $slug = trim($_POST['slug'] ?? '') ?: $this->slugify($name);
            $description = trim($_POST['description'] ?? '');

            if ($name) {
                Category::update((int)$id, [
                    'name' => $name,
                    'slug' => $slug,
                    'description' => $description
                ]);
                $this->redirect('/admin/categories');
            }
        }

        $this->render('admin/categories/form.tpl', [
            'page_title' => 'Edit Category',
            'category' => $category
        ]);
    }

    public function deleteCategory(string $id): void
    {
        Auth::requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Category::delete((int)$id);
        }
        $this->redirect('/admin/categories');
    }

    // Articles
    public function articles(): void
    {
        Auth::requireAuth();

        $this->render('admin/articles/index.tpl', [
            'page_title' => 'Articles',
            'articles' => Article::all()
        ]);
    }

    public function createArticle(): void
    {
        Auth::requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $slug = trim($_POST['slug'] ?? '') ?: $this->slugify($title);
            $description = trim($_POST['description'] ?? '');
            $content = $_POST['content'] ?? '';
            $image = trim($_POST['image'] ?? '');
            $categoryIds = $_POST['categories'] ?? [];

            if ($title) {
                $articleId = Article::create([
                    'title' => $title,
                    'slug' => $slug,
                    'description' => $description,
                    'content' => $content,
                    'image' => $image ?: null
                ]);

                if (!empty($categoryIds)) {
                    Article::syncCategories($articleId, $categoryIds);
                }

                $this->redirect('/admin/articles');
            }
        }

        $this->render('admin/articles/form.tpl', [
            'page_title' => 'Create Article',
            'article' => null,
            'categories' => Category::all(),
            'selected_categories' => []
        ]);
    }

    public function editArticle(string $id): void
    {
        Auth::requireAuth();

        $article = Article::find((int)$id);
        if (!$article) {
            $this->redirect('/admin/articles');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $slug = trim($_POST['slug'] ?? '') ?: $this->slugify($title);
            $description = trim($_POST['description'] ?? '');
            $content = $_POST['content'] ?? '';
            $image = trim($_POST['image'] ?? '');
            $categoryIds = $_POST['categories'] ?? [];

            if ($title) {
                Article::update((int)$id, [
                    'title' => $title,
                    'slug' => $slug,
                    'description' => $description,
                    'content' => $content,
                    'image' => $image ?: null
                ]);

                Article::syncCategories((int)$id, $categoryIds);

                $this->redirect('/admin/articles');
            }
        }

        $this->render('admin/articles/form.tpl', [
            'page_title' => 'Edit Article',
            'article' => $article,
            'categories' => Category::all(),
            'selected_categories' => Article::getCategoryIds((int)$id)
        ]);
    }

    public function deleteArticle(string $id): void
    {
        Auth::requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Article::delete((int)$id);
        }
        $this->redirect('/admin/articles');
    }

    // Seeder
    public function seed(): void
    {
        Auth::requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Clear existing data
            Article::deleteAll();
            Category::deleteAll();

            // Run seeder
            $this->runSeeder();

            $this->redirect('/admin?seeded=1');
        }

        $this->redirect('/admin');
    }

    private function runSeeder(): void
    {
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology', 'description' => 'Latest technology news and insights'],
            ['name' => 'Web Development', 'slug' => 'web-development', 'description' => 'Tutorials and tips for web developers'],
            ['name' => 'Design', 'slug' => 'design', 'description' => 'UI/UX design principles and inspiration'],
            ['name' => 'Business', 'slug' => 'business', 'description' => 'Business strategies and insights'],
        ];

        $categoryMap = [];
        foreach ($categories as $cat) {
            $id = Category::create($cat);
            $categoryMap[$cat['slug']] = $id;
        }

        $articles = [
            [
                'title' => 'Getting Started with PHP 8.2',
                'slug' => 'getting-started-with-php-82',
                'description' => 'A comprehensive guide to the new features in PHP 8.2',
                'content' => '<p>PHP 8.2 introduces several exciting new features.</p><h2>Readonly Classes</h2><p>You can now declare entire classes as readonly.</p>',
                'image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&h=400&fit=crop',
                'categories' => ['technology', 'web-development']
            ],
            [
                'title' => 'Modern CSS Grid Layouts',
                'slug' => 'modern-css-grid-layouts',
                'description' => 'Master CSS Grid with practical examples',
                'content' => '<p>CSS Grid has revolutionized web layouts.</p><h2>Grid Template Areas</h2><p>Named grid areas make complex layouts readable.</p>',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=400&fit=crop',
                'categories' => ['web-development', 'design']
            ],
            [
                'title' => 'Building REST APIs Best Practices',
                'slug' => 'building-rest-apis-best-practices',
                'description' => 'Essential guidelines for designing robust REST APIs',
                'content' => '<p>Creating a well-designed REST API is crucial.</p><h2>HTTP Methods</h2><ul><li>GET - Retrieve</li><li>POST - Create</li></ul>',
                'image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&h=400&fit=crop',
                'categories' => ['technology', 'web-development']
            ],
            [
                'title' => 'UI Design Principles',
                'slug' => 'ui-design-principles',
                'description' => 'Essential design principles every developer should know',
                'content' => '<p>Good design is not just for designers.</p><h2>Visual Hierarchy</h2><p>Guide users through content effectively.</p>',
                'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800&h=400&fit=crop',
                'categories' => ['design']
            ],
            [
                'title' => 'Database Optimization',
                'slug' => 'database-optimization',
                'description' => 'Improve your database performance',
                'content' => '<p>Database performance is critical.</p><h2>Indexing</h2><p>Proper indexing improves query performance dramatically.</p>',
                'image' => 'https://images.unsplash.com/photo-1544383835-bda2bc66a55d?w=800&h=400&fit=crop',
                'categories' => ['technology']
            ],
            [
                'title' => 'Startup Growth Strategies',
                'slug' => 'startup-growth-strategies',
                'description' => 'Proven strategies for scaling your startup',
                'content' => '<p>Growing a startup requires strategic thinking.</p><h2>Product-Market Fit</h2><p>Ensure strong fit before scaling.</p>',
                'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=400&fit=crop',
                'categories' => ['business']
            ],
        ];

        foreach ($articles as $index => $articleData) {
            $cats = $articleData['categories'];
            unset($articleData['categories']);

            $articleId = Article::create($articleData);

            foreach ($cats as $catSlug) {
                if (isset($categoryMap[$catSlug])) {
                    Article::attachCategory($articleId, $categoryMap[$catSlug]);
                }
            }

            // Random views and date offset
            $views = rand(10, 500);
            Database::query(
                'UPDATE articles SET views = ?, created_at = DATE_SUB(NOW(), INTERVAL ? DAY) WHERE id = ?',
                [$views, $index * 2, $articleId]
            );
        }
    }

    private function slugify(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        return preg_replace('~-+~', '-', $text);
    }
}
