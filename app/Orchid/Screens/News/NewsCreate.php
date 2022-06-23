<?php


namespace App\Orchid\Screens\News;


use App\Models\News;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Ramsey\Uuid\Uuid;

class NewsCreate extends Screen
{
    public $name = 'Create';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Page';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
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

            Layout::rows([
                Input::make('title')
                    ->title('Title'),

                Select::make('type')
                    ->title('Type')
                    ->options([
                        'iphone' => 'iphone',
                        'android'=> 'android',
                        'ipad'   => 'ipad',
                    ]),

                Input::make('price')
                    ->title('Price'),
            ]),

            Layout::rows([
                Cropper::make('image')
                    ->width(500)
                    ->height(500)
                    ->maxFileSize(2),
            ]),

            Layout::rows([
//                Quill::make('quill')
//                    ->title('Редактор')
//                    ->value(''),
//
                Button::make('Save')
                    ->method('save')
                    ->parameters([
                        'news' => 'news',
                    ])
                    ->type(Color::SUCCESS()),
            ]),
        ];
    }

    public function save(Request $request)
    {
        $news = new News();

        if($request->image && $request->image !== '') {

            $news->image = env('APP_PROTOCOL').$request->image;
        }

        $news->uuid  = Uuid::uuid4()->toString();
        $news->price = $request->price;
        $news->type  = $request->type;
        $news->title = $request->title;

        if ($news->save()) {

            $this->showToast($request);

            return redirect()->route('platform.'.$news->type.'.index');
        }
    }

    public function showToast(Request $request): void
    {
        Toast::success($request->get('toast', 'Success'));
    }
}
