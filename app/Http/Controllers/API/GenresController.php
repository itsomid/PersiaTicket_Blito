<?php

namespace App\Http\Controllers\API;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenresController extends Controller
{
    public function get()
    {
        return Genre::all();
    }
}
