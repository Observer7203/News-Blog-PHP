<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Core\Database;
use App\Models\Category;
use App\Models\Article;

echo "Starting seeder...\n";

$categories = [
    [
        'name' => 'Technology',
        'slug' => 'technology',
        'description' => 'Latest technology news, reviews, and insights about software, hardware, and digital innovation.'
    ],
    [
        'name' => 'Web Development',
        'slug' => 'web-development',
        'description' => 'Tutorials, tips, and best practices for modern web development.'
    ],
    [
        'name' => 'Design',
        'slug' => 'design',
        'description' => 'UI/UX design principles, tools, and inspiration for creative professionals.'
    ],
    [
        'name' => 'Business',
        'slug' => 'business',
        'description' => 'Business strategies, entrepreneurship, and industry insights.'
    ],
];

$articles = [
    [
        'title' => 'Getting Started with PHP 8.2',
        'slug' => 'getting-started-with-php-82',
        'description' => 'A comprehensive guide to the new features and improvements in PHP 8.2',
        'content' => '<p>PHP 8.2 introduces several exciting new features that make the language more powerful and developer-friendly.</p>
<h2>Readonly Classes</h2>
<p>One of the most notable additions is the ability to declare entire classes as readonly. This means all properties of the class are automatically readonly.</p>
<pre><code>readonly class User {
    public function __construct(
        public string $name,
        public string $email
    ) {}
}</code></pre>
<h2>Disjunctive Normal Form Types</h2>
<p>DNF types allow you to combine union and intersection types for more precise type declarations.</p>
<h2>Constants in Traits</h2>
<p>You can now define constants in traits, which was previously not possible.</p>
<p>These improvements make PHP 8.2 a significant upgrade for modern PHP development.</p>',
        'image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&h=400&fit=crop',
        'categories' => ['technology', 'web-development']
    ],
    [
        'title' => 'Modern CSS Grid Layouts',
        'slug' => 'modern-css-grid-layouts',
        'description' => 'Master CSS Grid with practical examples and real-world layouts',
        'content' => '<p>CSS Grid has revolutionized how we create layouts on the web. In this article, we explore advanced techniques.</p>
<h2>Grid Template Areas</h2>
<p>Named grid areas make complex layouts readable and maintainable.</p>
<pre><code>.container {
    display: grid;
    grid-template-areas:
        "header header"
        "sidebar main"
        "footer footer";
}</code></pre>
<h2>Auto-fit and Auto-fill</h2>
<p>Create responsive grids without media queries using auto-fit and minmax().</p>
<pre><code>grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));</code></pre>
<p>This creates a flexible grid that automatically adjusts the number of columns.</p>',
        'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=400&fit=crop',
        'categories' => ['web-development', 'design']
    ],
    [
        'title' => 'Building REST APIs Best Practices',
        'slug' => 'building-rest-apis-best-practices',
        'description' => 'Essential guidelines for designing and implementing robust REST APIs',
        'content' => '<p>Creating a well-designed REST API is crucial for modern web applications.</p>
<h2>Use Proper HTTP Methods</h2>
<ul>
<li>GET - Retrieve resources</li>
<li>POST - Create new resources</li>
<li>PUT - Update existing resources</li>
<li>DELETE - Remove resources</li>
</ul>
<h2>Consistent Naming Conventions</h2>
<p>Use plural nouns for resources: /users, /articles, /categories</p>
<h2>Proper Status Codes</h2>
<p>Return appropriate HTTP status codes to indicate the result of operations.</p>
<h2>Versioning</h2>
<p>Always version your API to maintain backward compatibility.</p>',
        'image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&h=400&fit=crop',
        'categories' => ['technology', 'web-development']
    ],
    [
        'title' => 'UI Design Principles for Developers',
        'slug' => 'ui-design-principles-for-developers',
        'description' => 'Essential design principles every developer should know',
        'content' => '<p>Good design is not just for designers. Developers can improve their work by understanding core design principles.</p>
<h2>Visual Hierarchy</h2>
<p>Guide users through content by establishing clear visual hierarchy using size, color, and spacing.</p>
<h2>Consistency</h2>
<p>Maintain consistent patterns throughout your interface for a cohesive experience.</p>
<h2>White Space</h2>
<p>Don\'t be afraid of empty space. It improves readability and focus.</p>
<h2>Color Theory</h2>
<p>Use colors intentionally to convey meaning and create emotional responses.</p>',
        'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800&h=400&fit=crop',
        'categories' => ['design']
    ],
    [
        'title' => 'Database Optimization Techniques',
        'slug' => 'database-optimization-techniques',
        'description' => 'Improve your database performance with these proven strategies',
        'content' => '<p>Database performance is critical for application responsiveness.</p>
<h2>Indexing</h2>
<p>Proper indexing can dramatically improve query performance. Index columns used in WHERE, JOIN, and ORDER BY clauses.</p>
<h2>Query Optimization</h2>
<p>Analyze slow queries using EXPLAIN and optimize them. Avoid SELECT * when possible.</p>
<h2>Connection Pooling</h2>
<p>Reuse database connections to reduce overhead.</p>
<h2>Caching</h2>
<p>Implement caching strategies to reduce database load.</p>',
        'image' => 'https://images.unsplash.com/photo-1544383835-bda2bc66a55d?w=800&h=400&fit=crop',
        'categories' => ['technology', 'web-development']
    ],
    [
        'title' => 'Startup Growth Strategies',
        'slug' => 'startup-growth-strategies',
        'description' => 'Proven strategies for scaling your startup effectively',
        'content' => '<p>Growing a startup requires strategic thinking and execution.</p>
<h2>Product-Market Fit</h2>
<p>Before scaling, ensure you have strong product-market fit. Talk to customers constantly.</p>
<h2>Growth Metrics</h2>
<p>Track the right metrics: CAC, LTV, churn rate, and activation rates.</p>
<h2>Building a Team</h2>
<p>Hire people who complement your skills and share your vision.</p>
<h2>Funding</h2>
<p>Understand when and how to raise capital without over-diluting.</p>',
        'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=400&fit=crop',
        'categories' => ['business']
    ],
    [
        'title' => 'Introduction to Docker',
        'slug' => 'introduction-to-docker',
        'description' => 'Learn the basics of containerization with Docker',
        'content' => '<p>Docker has transformed how we deploy and manage applications.</p>
<h2>What is Docker?</h2>
<p>Docker is a platform for developing, shipping, and running applications in containers.</p>
<h2>Key Concepts</h2>
<ul>
<li>Images - Read-only templates</li>
<li>Containers - Running instances of images</li>
<li>Dockerfile - Instructions to build images</li>
<li>Docker Compose - Multi-container orchestration</li>
</ul>
<h2>Benefits</h2>
<p>Consistency across environments, isolation, and easy scaling.</p>',
        'image' => 'https://images.unsplash.com/photo-1605745341112-85968b19335b?w=800&h=400&fit=crop',
        'categories' => ['technology', 'web-development']
    ],
    [
        'title' => 'Color Psychology in Web Design',
        'slug' => 'color-psychology-web-design',
        'description' => 'How colors influence user behavior and emotions',
        'content' => '<p>Colors have a profound impact on how users perceive and interact with websites.</p>
<h2>Blue - Trust and Security</h2>
<p>Often used by banks and tech companies to convey reliability.</p>
<h2>Red - Urgency and Passion</h2>
<p>Effective for CTAs and sales, but use sparingly.</p>
<h2>Green - Growth and Nature</h2>
<p>Associated with health, wealth, and environmental themes.</p>
<h2>Best Practices</h2>
<p>Choose colors that align with your brand values and target audience expectations.</p>',
        'image' => 'https://images.unsplash.com/photo-1541701494587-cb58502866ab?w=800&h=400&fit=crop',
        'categories' => ['design']
    ],
    [
        'title' => 'JavaScript Performance Tips',
        'slug' => 'javascript-performance-tips',
        'description' => 'Optimize your JavaScript code for better performance',
        'content' => '<p>Performance matters for user experience and SEO.</p>
<h2>Minimize DOM Manipulation</h2>
<p>Batch DOM updates and use document fragments when possible.</p>
<h2>Debouncing and Throttling</h2>
<p>Limit expensive function calls for scroll and resize events.</p>
<h2>Lazy Loading</h2>
<p>Load resources only when needed to improve initial page load.</p>
<h2>Memory Management</h2>
<p>Avoid memory leaks by properly cleaning up event listeners and references.</p>',
        'image' => 'https://images.unsplash.com/photo-1627398242454-45a1465c2479?w=800&h=400&fit=crop',
        'categories' => ['web-development']
    ],
    [
        'title' => 'Remote Work Best Practices',
        'slug' => 'remote-work-best-practices',
        'description' => 'Tips for staying productive while working remotely',
        'content' => '<p>Remote work offers flexibility but requires discipline.</p>
<h2>Create a Dedicated Workspace</h2>
<p>Having a separate work area helps maintain work-life boundaries.</p>
<h2>Communication</h2>
<p>Over-communicate with your team. Use video calls when possible.</p>
<h2>Time Management</h2>
<p>Use techniques like Pomodoro to stay focused and avoid burnout.</p>
<h2>Tools</h2>
<p>Invest in good tools: reliable internet, comfortable chair, proper lighting.</p>',
        'image' => 'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=800&h=400&fit=crop',
        'categories' => ['business']
    ],
    [
        'title' => 'Responsive Typography Guide',
        'slug' => 'responsive-typography-guide',
        'description' => 'Create beautiful, readable text across all devices',
        'content' => '<p>Typography is fundamental to good web design.</p>
<h2>Fluid Typography</h2>
<p>Use clamp() for responsive font sizes without media queries.</p>
<pre><code>font-size: clamp(1rem, 2.5vw, 2rem);</code></pre>
<h2>Line Height</h2>
<p>Optimal line height is typically 1.5-1.7 for body text.</p>
<h2>Font Pairing</h2>
<p>Combine fonts with contrasting characteristics for visual interest.</p>
<h2>Accessibility</h2>
<p>Ensure sufficient contrast and readable sizes for all users.</p>',
        'image' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=800&h=400&fit=crop',
        'categories' => ['design', 'web-development']
    ],
    [
        'title' => 'AI in Business Applications',
        'slug' => 'ai-business-applications',
        'description' => 'How artificial intelligence is transforming modern business',
        'content' => '<p>AI is no longer just for tech giants. Businesses of all sizes can leverage AI.</p>
<h2>Customer Service</h2>
<p>Chatbots and AI assistants can handle routine inquiries 24/7.</p>
<h2>Data Analysis</h2>
<p>AI can identify patterns and insights in large datasets.</p>
<h2>Personalization</h2>
<p>Deliver personalized experiences based on user behavior.</p>
<h2>Automation</h2>
<p>Automate repetitive tasks to free up human resources for creative work.</p>',
        'image' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&h=400&fit=crop',
        'categories' => ['technology', 'business']
    ],
];

try {
    echo "Creating categories...\n";
    $categoryMap = [];
    foreach ($categories as $categoryData) {
        $id = Category::create($categoryData);
        $categoryMap[$categoryData['slug']] = $id;
        echo "  Created category: {$categoryData['name']}\n";
    }

    echo "\nCreating articles...\n";
    foreach ($articles as $index => $articleData) {
        $categoryIds = [];
        foreach ($articleData['categories'] as $categorySlug) {
            if (isset($categoryMap[$categorySlug])) {
                $categoryIds[] = $categoryMap[$categorySlug];
            }
        }

        unset($articleData['categories']);

        $articleId = Article::create($articleData);

        foreach ($categoryIds as $categoryId) {
            Article::attachCategory($articleId, $categoryId);
        }

        // Add some random views
        $views = rand(10, 500);
        Database::query('UPDATE articles SET views = ?, created_at = DATE_SUB(NOW(), INTERVAL ? DAY) WHERE id = ?', [
            $views,
            $index * 2,
            $articleId
        ]);

        echo "  Created article: {$articleData['title']}\n";
    }

    echo "\nSeeding completed successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
