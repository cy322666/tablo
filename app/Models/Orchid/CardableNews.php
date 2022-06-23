<?php


namespace App\Models\Orchid;


use Orchid\Screen\Contracts\Cardable;
use Orchid\Support\Color;

class CardableNews implements Cardable
{
    public $title;

    public function __construct($model)
    {
        $this->title = $model->title;
        $this->description = $model->text;
        $this->image = $model->image;
    }

    /**
     * @return string
     */
    public function title() :string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function description() : string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function image() : string
    {
        return $this->image;
    }

    /**
     * @return Color
     */
    public function color(): ?Color
    {
        return Color::LINK();
    }
}
