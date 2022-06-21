<?php

namespace App\Orchid\Screens\Post;

use App\Orchid\Layouts\Examples\ChartBarExample;
use App\Orchid\Layouts\Examples\ChartLineExample;
use App\Orchid\Layouts\Examples\ChartPercentageExample;
use App\Orchid\Layouts\Examples\ChartPieExample;
use Illuminate\Http\Request;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Contracts\Cardable;
use Orchid\Screen\Layouts\Card;
use Orchid\Screen\Layouts\Content;
use Orchid\Screen\Layouts\Facepile;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PostDetail extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Детали';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Детали поста';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'post'      => new Repository([
                'id' => '100',
                'name'       => 'Название поста',
                'author' => 'Ivan',
                'strike' => '2',
                'created_at' => '01.01.2020',
                'status' => 'Активен',
            ]),
            'card' => new class implements Cardable {
                /**
                 * @return string
                 */
                public function title(): string
                {
                    return 'Название поста';
                }

                /**
                 * @return string
                 */
                public function description(): string
                {
                    return 'This is a wider card with supporting text below as a natural lead-in to additional content.
                            This content is a little bit longer. Mauris a orci congue, placerat lorem ac, aliquet est.
                            Etiam bibendum, urna et hendrerit molestie, risus est tincidunt lorem, eu suscipit tellus
                            odio vitae nulla. Sed a cursus ipsum. Maecenas quis finibus libero. Phasellus a nibh rutrum,
                            molestie orci sit amet, euismod ex. Donec finibus sodales magna, quis fermentum augue
                            pretium ac.';
                }

                /**
                 * @return string
                 */
                public function image(): ?string
                {
                    return 'https://picsum.photos/600/300';
                }

                /**
                 * @return \Orchid\Support\Color|string
                 */
                public function color(): ?Color
                {
                    return Color::SUCCESS();
                }

                /**
                 * @return \Orchid\Support\Color|string
                 */
                public function status(): ?Color
                {
                    return Color::SUCCESS();
                }
            },
            'cardPersona1'    => new class implements Cardable {
                /**
                 * @return string
                 */
                public function title(): string
                {
                    return 'Виктор Викторович Викторов';
                }

                /**
                 * @return string
                 */
                public function description(): string
                {
                    return
                        '<p>Короткое описание из анкеты пользователя</p>'.
                        new Facepile(User::limit(1)->get()->map->presenter());
                }

                /**
                 * @return string
                 */
                public function image(): ?string
                {
                    return null;
                }

                /**
                 * @return mixed
                 */
                public function color(): ?Color
                {
                    return Color::DANGER();
                }

                /**
                 * {@inheritdoc}
                 */
                public function status(): ?Color
                {
                    return Color::INFO();
                }
            },
            'cardPersona2'    => new class implements Cardable {
                /**
                 * @return string
                 */
                public function title(): string
                {
                    return 'Иванов Иван Иванович';
                }

                /**
                 * @return string
                 */
                public function description(): string
                {
                    return
                        '<p>Короткое описание из анкеты пользователя.</p>'.
                        new Facepile(User::limit(1)->get()->map->presenter());
                }

                /**
                 * @return string
                 */
                public function image(): ?string
                {
                    return null;
                }

                /**
                 * @return mixed
                 */
                public function color(): ?Color
                {
                    return Color::SUCCESS();
                }

                /**
                 * {@inheritdoc}
                 */
                public function status(): ?Color
                {
                    return Color::SUCCESS();
                }
            },
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::legend('post', [
                Sight::make('id'),
                //Sight::make('name', 'Название'),
                Sight::make('strike', 'Жалоб'),
                Sight::make('status', 'Статус')->render(function () {
                    return '<i class="text-success">●</i> Активный';
                }),
                Sight::make('created_at', 'Создан'),
            ]),

            Layout::columns([
                [
                    new Card('card', [
                        Button::make('Заблокировать')
                            ->method('showToast')
                            ->icon('trash'),
                        Button::make('Посмотреть')
                            ->icon('Посмотреть')
                            ->icon('info'),
                    ]),
                ],
            ]),

            Layout::accordion([

                'Автор поста' => [
                    new Card('cardPersona1', [
                        Button::make('Заблокировать')
                            ->method('showToast')
                            ->icon('trash'),

                        Button::make('Посмотреть')
                            ->icon('Посмотреть')
                            ->icon('info'),
                    ]),
                ],

                'Авторы жалоб' => [
                    Layout::columns([
                        [
                            new Card('cardPersona1', [
                                Button::make('Заблокировать')
                                    ->method('showToast')
                                    ->icon('trash'),

                                Button::make('Посмотреть')
                                    ->icon('Посмотреть')
                                    ->icon('info'),
                            ]),
                            new Card('cardPersona2', [
                                Button::make('Заблокировать')
                                    ->method('showToast')
                                    ->icon('trash'),

                                Button::make('Посмотреть')
                                    ->icon('Посмотреть')
                                    ->icon('info'),
                            ]),
                        ],
                    ]),
                ]
            ]),
        ];
    }

    public function showToast(Request $request): void
    {
        Toast::success($request->get('toast', 'Успешно'));
    }
}
