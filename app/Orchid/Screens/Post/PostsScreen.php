<?php

namespace App\Orchid\Screens\Post;

use App\Orchid\Layouts\Examples\ChartBarExample;
use App\Orchid\Layouts\Examples\ChartLineExample;
use App\Orchid\Layouts\Examples\MetricsExample;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PostsScreen extends Screen
{
    /**
     * Fish text for the table.
     */
    public const TEXT_EXAMPLE = 'Lorem ipsum at sed ad fusce faucibus primis, potenti inceptos ad taciti nisi tristique
    urna etiam, primis ut lacus habitasse malesuada ut. Lectus aptent malesuada mattis ut etiam fusce nec sed viverra,
    semper mattis viverra malesuada quam metus vulputate torquent magna, lobortis nec nostra nibh sollicitudin
    erat in luctus.';

    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Посты';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Список постов с жалобами';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'charts'  => [
            ],
            'table'   => [
                new Repository(['id' => 10,  'name' => self::TEXT_EXAMPLE, 'price' => 11, 'created_at' => '01.01.2020']),
                new Repository(['id' => 110, 'name' => self::TEXT_EXAMPLE, 'price' => 1, 'created_at' => '01.01.2020']),
                new Repository(['id' => 120, 'name' => self::TEXT_EXAMPLE, 'price' => 14, 'created_at' => '01.01.2020']),
                new Repository(['id' => 130, 'name' => self::TEXT_EXAMPLE, 'price' => 2, 'created_at' => '01.01.2020']),
                new Repository(['id' => 140, 'name' => self::TEXT_EXAMPLE, 'price' => 24, 'created_at' => '01.01.2020']),
                new Repository(['id' => 150, 'name' => self::TEXT_EXAMPLE, 'price' => 9, 'created_at' => '01.01.2020']),
                new Repository(['id' => 155, 'name' => self::TEXT_EXAMPLE, 'price' => 14, 'created_at' => '01.01.2020']),
            ],
            'metrics' => [
                ['keyValue' => number_format(6851, 0), 'keyDiff' => 10.08],
            ],
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
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [

            Layout::table('table', [
                TD::make('id', 'ID')
                    ->width('150')
                    ->render(function (Repository $model) {
                        // Please use view('path')
                        return "<img src='https://picsum.photos/450/200?random={$model->get('id')}'
                              alt='sample'
                              class='mw-100 d-block img-fluid'>

                            <span class='small text-muted mt-1 mb-0'><a href=/admin/posts/detail># {$model->get('id')}</a></span>";
                    }),//

                TD::make('name', 'Name')
                    ->width('450')
                    ->render(function (Repository $model) {
                        return Str::limit($model->get('name'), 200);
                    }),

                TD::make('price', 'Жалоб')
                    ->render(function (Repository $model) {
                        return $model->get('price', 2);
                    }),

                TD::make('created_at', 'Создан'),

                TD::make('block', 'Block')
                    ->render(function (Repository $model) {

                        $rand = rand(0,2);

                        if($rand == 0) {

                            $text = 'Разблокировать';
                            $icon = 'like';
                            $type = Color::SUCCESS();
                            $confirmText = 'После подтверждения пост разблокируется';

                        } else {

                            $text = 'Заблокировать';
                            $type = Color::DANGER();
                            $confirmText = 'После подтверждения пост заблокируется';
                            $icon = 'trash';
                        }

                        return Button::make(__($text))
                            ->icon($icon)
                            ->method('alert')
                            ->type($type)
                            ->confirm(__($confirmText))
                            ->parameters([
                                'id' => $model->get('id'),
                            ]);
                    }
                    )
            ]),
        ];
    }

    public function alert(Request $request)
    {
        Toast::success($request->get('toast', 'Успешно'));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        return response()->streamDownload(function () {
            $csv = tap(fopen('php://output', 'wb'), function ($csv) {
                fputcsv($csv, ['header:col1', 'header:col2', 'header:col3']);
            });

            collect([
                ['row1:col1', 'row1:col2', 'row1:col3'],
                ['row2:col1', 'row2:col2', 'row2:col3'],
                ['row3:col1', 'row3:col2', 'row3:col3'],
            ])->each(function (array $row) use ($csv) {
                fputcsv($csv, $row);
            });

            return tap($csv, function ($csv) {
                fclose($csv);
            });
        }, 'File-name.csv');
    }
}
