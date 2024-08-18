<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;


class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // استخدام طريقة insertArticle لإضافة المقالات مع الفئات والوسوم الخاصة بها
       $this->insertArticle(
        'Football Match Announcement',
        'Details about the upcoming football match...',
        [1, 2], // معرفات الفئات
        [1, 2],  // معرفات الوسوم
        now(),
        now()
    );

    $this->insertArticle(
        'Health and Fitness Tips',
        'Some tips for maintaining a healthy and fit body...',
        [1],    
        [2],
        now(),
        now()
    );
}

private function insertArticle($title, $content, $categoryIds, $tagIds, $createdAt, $updatedAt)
{
    $article = Article::create([
        'name' => $title,
        'content' => $content,
        'created_at' => $createdAt,
        'updated_at' => $updatedAt
    ]);

    $article->categories()->sync($categoryIds);
    $article->tags()->sync($tagIds);
}

    }

