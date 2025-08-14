<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Test endpoint is working!'
        ], 200, [
            'Content-Type' => 'application/json; charset=UTF-8'
        ]);
    }
}
