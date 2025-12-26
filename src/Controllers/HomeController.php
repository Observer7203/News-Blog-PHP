<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(): void
    {
        $categories = Category::withArticles();

        $this->render('pages/home.tpl', [
            'categories' => $categories,
            'page_title' => 'Home'
        ]);
    }
}
