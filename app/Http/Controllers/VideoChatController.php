<?php

namespace App\Http\Controllers;

use App\Domains\User\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VideoChatController extends Controller
{
    public function index(Request $request) {
        return Inertia::render('Video/Index');
    }
}
