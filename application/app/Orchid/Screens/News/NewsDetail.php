<?php

namespace App\Orchid\Screens\News;

use App\Models\News;
use App\Models\Orchid\CardableNews;
use App\Orchid\Layouts\DetailLayout;
use App\Orchid\Layouts\Examples\ChartBarExample;
use App\Orchid\Layouts\Examples\ChartLineExample;
use App\Orchid\Layouts\Examples\ChartPercentageExample;
use App\Orchid\Layouts\Examples\ChartPieExample;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Contracts\Cardable;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Card;
use Orchid\Screen\Layouts\Content;
use Orchid\Screen\Layouts\Facepile;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class NewsDetail extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Details';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Page';

    public $news;
    /**
     * Query data.
     *
     * @return array
     */
    public function query(News $news): array
    {
        $this->news = $news;

        return [
            'news'  => $news,
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

            Layout::columns([
                [
                    Layout::rows([
                        Input::make('title')
                            ->title('Title')
                            ->value($this->news->title),
                        Input::make('price')
                            ->title('Price')
                            ->value($this->news->price),
                        Input::make('type')
                            ->title('Type')
                            ->value($this->news->type)
                            ->readonly(true),
                    ]),
                ],
                [
                    Layout::view('layouts.image', [
                        'image' => $this->news->image
                    ])
                ]
            ]),

            Layout::rows([
                Cropper::make('image')
                    ->width(500)
                    ->height(500)
                    ->maxFileSize(2),
            ]),

            Layout::rows([
                Group::make([

                    Button::make('Save')
                        ->method('save')
                        ->icon('save')
                        ->parameters([
                            'news' => 'news',
                        ])->type(Color::SUCCESS()),

                    Button::make('Delete')
                        ->icon('trash')
                        ->type(Color::DANGER())
                        ->confirm(__('Are you sure?'))
                        ->method('alert')
                        ->parameters([
                            'news' => 'news',
                        ])->type(Color::DANGER()),

                ])->autoWidth(),
            ])
        ];
    }

    public function save(Request $request, $news)
    {
        $news = News::where('id', $news)->first();

        if($request->image && $request->image !== '') {

            $news->image = env('APP_PROTOCOL').$request->image;
        }

        $news->price = $request->price;
        $news->title = $request->title;
        $news->save();

        if($news->save())
            $this->showToast($request);

        return redirect()->route('platform.'.$news->type.'.index');
    }

    public function showToast(Request $request): void
    {
        Toast::success($request->get('toast', 'Успешно'));
    }

    public function alert(Request $request, $news)
    {
        $news = News::where('id', $news)->first();

        if($news->delete()) {

            Toast::success($request->get('toast', 'Success'));
        }
    }
}
