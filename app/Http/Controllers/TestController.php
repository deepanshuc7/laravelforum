<?php

namespace App\Http\Controllers;

use App\Models\Discussion;

class TestController extends Controller
{
    public function index()
    {
        $discussions = Discussion::all();
        return response()->json($discussions);
    }
}
