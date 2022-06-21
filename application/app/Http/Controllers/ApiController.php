<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsCollection;
use App\Models\News;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function iphones(): NewsCollection
    {
        return new NewsCollection(
            News::query()
                ->where('type', 'iphone')
                ->get()
        );
    }

    public function androids(): NewsCollection
    {
        return new NewsCollection(
            News::query()
                ->where('type', 'android')
                ->get()
        );
    }

    public function ipads(): NewsCollection
    {
        return new NewsCollection(
            News::query()
                ->where('type', 'ipad')
                ->get()
        );
    }
}
