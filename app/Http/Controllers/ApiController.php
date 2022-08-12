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
                ->orderBy('created_at')
                ->where('type', 'iphone')
                ->get()
        );
    }

    public function androids(): NewsCollection
    {
        return new NewsCollection(
            News::query()
                ->orderBy('created_at')
                ->where('type', 'android')
                ->get()
        );
    }

    public function ipads(): NewsCollection
    {
        return new NewsCollection(
            News::query()
                ->orderBy('created_at')
                ->where('type', 'ipad')
                ->get()
        );
    }
}
