<?php

namespace App\Orchid\Screens\News;

use App\Models\News;
use App\Orchid\Layouts\Examples\ChartBarExample;
use App\Orchid\Layouts\Examples\ChartLineExample;
use App\Orchid\Layouts\Examples\MetricsExample;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class NewsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Новости';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Список новостей';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'news'  => News::all(),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make(__('Создать'))
                ->icon('plus')
                ->href(route('platform.create')),
        ];
    }

    /**
     * Views.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [

            Layout::table('news', [
                TD::make('image', 'Картинка')
                    ->render(function (News $model) {
                        // Please use view('path')
                        return "<img src=$model->image
                              alt='sample'
                              width='250'>";
                    }),

                TD::make('title', 'Название')
                    ->width('250')
                    ->render(function (News $model) {
                        return Str::limit($model->title, 200);
                    }),

                TD::make('created_at', 'Создан')
                    ->render(function (News $model) {

                    return Str::limit($model->created_at, 200);
                }),

                TD::make('block', 'Действие')
                    ->render(function (News $model) {

                        return Link::make('Изменить')->href('/admin/news/detail/'.$model->id);
//                        return Button::make(__('Правки'))
//                            ->icon('pencil')
//                            ->method('detail')
//                            ->type(Color::PRIMARY())
//                            ->parameters([
//                                'id' => $model->get('id'),
//                            ]);
                    }
                    )
            ]),
        ];
    }

    public function alert(Request $request)
    {
        Toast::success($request->get('toast', 'Успешно'));
    }

    public function detail($id)
    {
        //dd(env('APP_URL').'/news/detail/'.$id);
        redirect(env('APP_URL').'/admin/posts/detail/1'.$id);
    }
}
