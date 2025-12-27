<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\CategoryController;
use App\Controllers\ArticleController;
use App\Controllers\AdminController;

$router = new Router();

// Public routes
$router->get('/', [HomeController::class, 'index']);
$router->get('/category/{slug}', [CategoryController::class, 'show']);
$router->get('/article/{slug}', [ArticleController::class, 'show']);

// Admin routes
$router->get('/admin/login', [AdminController::class, 'login']);
$router->post('/admin/login', [AdminController::class, 'login']);
$router->get('/admin/logout', [AdminController::class, 'logout']);
$router->get('/admin', [AdminController::class, 'dashboard']);

// Admin Categories
$router->get('/admin/categories', [AdminController::class, 'categories']);
$router->get('/admin/categories/create', [AdminController::class, 'createCategory']);
$router->post('/admin/categories/create', [AdminController::class, 'createCategory']);
$router->get('/admin/categories/edit/{id}', [AdminController::class, 'editCategory']);
$router->post('/admin/categories/edit/{id}', [AdminController::class, 'editCategory']);
$router->post('/admin/categories/delete/{id}', [AdminController::class, 'deleteCategory']);

// Admin Articles
$router->get('/admin/articles', [AdminController::class, 'articles']);
$router->get('/admin/articles/create', [AdminController::class, 'createArticle']);
$router->post('/admin/articles/create', [AdminController::class, 'createArticle']);
$router->get('/admin/articles/edit/{id}', [AdminController::class, 'editArticle']);
$router->post('/admin/articles/edit/{id}', [AdminController::class, 'editArticle']);
$router->post('/admin/articles/delete/{id}', [AdminController::class, 'deleteArticle']);

// Admin Seeder
$router->post('/admin/seed', [AdminController::class, 'seed']);

$router->dispatch();
