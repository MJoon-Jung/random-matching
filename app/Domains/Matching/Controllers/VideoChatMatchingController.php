<?php

namespace App\Domains\Matching\Controllers;

use App\Domains\Matching\Services\ChatMatchingService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VideoChatMatchingController extends Controller
{
    public function __construct(private ChatMatchingService $matchingService)
    {
    }

    public function index()
    {
        return Inertia::render('Matching/VideoChat/Index');
    }
    public function wait()
    {
    }

    public function cancel()
    {

    }

    public function connect()
    {
        $result = ['status' => 200];
        try {
//            $result['data'] = $this->matchingService->connect();
            $this->matchingService->connect();
        } catch (\Exception $e) {
            $result = [
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ];
        }
        return response()->json($result, $result['status']);
    }

    public function store()
    {

    }

    public function disconnect()
    {

    }
}
