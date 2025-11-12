<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publishedPosts = [
            [
                'title' => 'Путешествие по Карелии: гид для начинающих',
                'intro' => 'Основные советы и маршруты для первой поездки в Карелию: как добраться, что посмотреть и где остановиться.',
                'body' => $this->formatBody([
                    'Карелия — один из самых живописных регионов России. Здесь можно найти десятки водопадов, спокойные озера и древние леса.',
                    'Для поездки начинающим путешественникам подойдут маршруты по Ладожскому озеру и острову Кижи, а также экскурсии по старинным деревням.',
                    'Выбирайте летний сезон для прогулок на теплоходах и велосипедных туров, а в межсезонье обратите внимание на спа-комплексы.',
                ]),
                'cover_path' => 'covers/karelia-lakes.jpg',
                'published_at' => Carbon::create(2025, 7, 18, 9, 30),
            ],
            [
                'title' => 'Как организовать уютный уголок дома для чтения',
                'intro' => 'Подбираем освещение, мебель и текстиль, чтобы создать комфортную атмосферу для вечерних книг.',
                'body' => $this->formatBody([
                    'Небольшой уголок для чтения можно обустроить даже в студии: главное — выделить отдельную зону и правильное освещение.',
                    'Используйте светильники с тёплым светом и кресло с поддержкой спины. Добавьте плед, журнальный столик и пару растений.',
                    'Храните книги в открытом стеллаже или на навесных полках — это создаст настроение библиотеки и вдохновит читать чаще.',
                ]),
                'cover_path' => 'covers/reading-nook.jpg',
                'published_at' => Carbon::create(2025, 8, 5, 18, 15),
            ],
            [
                'title' => 'Вегетарианское меню на неделю: сезонные идеи',
                'intro' => 'Собрали простые рецепты на семь дней из сезонных овощей: сытные супы, пасты и выпечка.',
                'body' => $this->formatBody([
                    'При составлении меню ориентируйтесь на сезонные продукты: осенью вегетарианские блюда можно строить вокруг тыквы, свёклы и капусты.',
                    'Запекайте овощи с оливковым маслом и травами, готовьте густые супы-пюре и тёплые салаты с крупами — это питательно и быстро.',
                    'Для разнообразия добавляйте в рацион бобовые, цельнозерновые продукты и ферментированные напитки.',
                ]),
                'cover_path' => null,
                'published_at' => Carbon::create(2025, 9, 2, 12, 45),
            ],
        ];

        foreach ($publishedPosts as $postData) {
            Post::factory()
                ->published()
                ->state(fn (array $attributes): array => [
                    'title' => $postData['title'],
                    'slug' => Str::slug($postData['title']),
                    'intro' => $postData['intro'],
                    'body' => $postData['body'],
                    'cover_path' => $postData['cover_path'],
                    'published_at' => $postData['published_at'],
                ])
                ->create();
        }

        Post::factory()
            ->count(2)
            ->state(new Sequence(
                ['title' => 'Идеи для воскресных прогулок по городу', 'slug' => Str::slug('Идеи для воскресных прогулок по городу')],
                ['title' => 'Как прокачать личный To-Do список на месяц', 'slug' => Str::slug('Как прокачать личный To-Do список на месяц')],
            ))
            ->create();
    }

    /**
     * @param  list<string>  $paragraphs
     */
    private function formatBody(array $paragraphs): string
    {
        return collect($paragraphs)
            ->map(fn (string $paragraph): string => "<p>{$paragraph}</p>")
            ->implode("\n\n");
    }
}
