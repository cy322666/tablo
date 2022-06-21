<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class News extends Model
{
    use AsSource;

    protected $fillable = [
        'text',
        'title',
        'image',
        'uuid',
        'type',
    ];

    protected $hidden = [
        'id',
        'status',
        'type',
    ];

    public function getContent(): News
    {
        return $this;
    }
}
