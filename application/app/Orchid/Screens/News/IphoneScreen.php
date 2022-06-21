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

class IphoneScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Iphones';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'List';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'news'  => News::query()
                ->where('type', 'iphone')
                ->get(),
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
            Link::make(__('Create'))
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
                TD::make('image', 'Picture')
                    ->render(function (News $model) {
                        // Please use view('path')
                        return "<img src=$model->image
                              alt='sample'
                              width='250'>";
                    }),

                TD::make('title', 'Title')
                    ->width('250')
                    ->render(function (News $model) {
                        return Str::limit($model->title, 200);
                    }),

                TD::make('created_at', 'Created at')
                    ->render(function (News $model) {

                    return Str::limit($model->created_at, 200);
                }),

                TD::make('price', 'Price')
                    ->render(function (News $model) {

                        return $model->price;
                    }),

                TD::make('block', 'Action')
                    ->render(function (News $model) {

                        return Button::make(__('Change'))
                            ->icon('pencil')
                            ->method('detail', [
                                'id' => $model->id,
                            ])
                            ->type(Color::DARK());
                        }
                    )
            ]),
        ];
    }

    public function detail($id)
    {
        return redirect()->route('platform.detail', $id);
    }

    public function alert(Request $request)
    {
        Toast::success($request->get('toast', 'Успешно'));
    }
}
