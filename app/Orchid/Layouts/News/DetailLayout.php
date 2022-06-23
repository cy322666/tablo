<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Layouts\Rows;

class DetailLayout extends Rows
{
    /**
     * @var string
     */
    public $image;

    /**
     * ReusableEditLayout constructor.
     *
     * @param string $prefix
     * @param string $title
     */
    public function __construct(string $image = '')
    {
        $this->image = $image;
    }

    /**
     * Views.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Label::make('label')
                ->title($this->title),

            Input::make($this->prefix . '.address')
                ->required()
                ->title('Address')
                ->placeholder('177A Bleecker Street'),
        ];
    }
}
