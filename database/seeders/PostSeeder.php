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
                'title' => 'Подорож Карелією: гід для початківців',
                'intro' => 'Основні поради та маршрути для першої мандрівки Карелією: як дістатися, що побачити та де зупинитися.',
                'body' => $this->formatBody([
                    'Карелія — один із наймальовничіших регіонів Півночі. Тут ви знайдете десятки водоспадів, спокійні озера та стародавні ліси.',
                    'Початківцям мандрівникам підійдуть маршрути навколо Ладозького озера й острова Кіжі, а також екскурсії історичними поселеннями.',
                    'Для літнього сезону обирайте прогулянки теплоходами та велосипедні тури, а в міжсезоння зверніть увагу на спа-комплекси.',
                ]),
                'cover_path' => 'covers/karelia-lakes.jpg',
                'published_at' => Carbon::create(2025, 7, 18, 9, 30),
            ],
            [
                'title' => 'Як облаштувати затишний куточок для читання вдома',
                'intro' => 'Підбираємо освітлення, меблі й текстиль, щоб створити комфортну атмосферу для вечірнього читання.',
                'body' => $this->formatBody([
                    'Невеликий куточок для читання можна організувати навіть у студії — головне відокремити зону та подбати про м’яке світло.',
                    'Використовуйте світильники з теплим відтінком і крісло з підтримкою спини. Додайте плед, журнальний столик та кілька рослин.',
                    'Зберігайте книжки на відкритих полицях або у стелажі — це створить бібліотечний настрій і надихатиме читати частіше.',
                ]),
                'cover_path' => 'covers/reading-nook.jpg',
                'published_at' => Carbon::create(2025, 8, 5, 18, 15),
            ],
            [
                'title' => 'Вегетаріанське меню на тиждень: сезонні ідеї',
                'intro' => 'Зібрали прості рецепти на сім днів із сезонних овочів: ситні супи, пасти та випічка.',
                'body' => $this->formatBody([
                    'Складаючи меню, орієнтуйтеся на сезонні продукти: восени готуйте страви з гарбуза, буряка та капусти.',
                    'Запікайте овочі з оливковою олією та спеціями, готуйте густі супи-пюре й теплі салати з крупами — це поживно й швидко.',
                    'Для різноманіття додавайте в раціон бобові, цільнозернові продукти та ферментовані напої.',
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
                ['title' => 'Ідеї для недільних прогулянок містом', 'slug' => Str::slug('Ідеї для недільних прогулянок містом')],
                ['title' => 'Як прокачати особистий To-Do список на місяць', 'slug' => Str::slug('Як прокачати особистий To-Do список на місяць')],
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
