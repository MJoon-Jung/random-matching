<?php

namespace App\Domains\Matching\Controllers;

use App\Domains\Matching\Services\MatchingService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatMatchingController extends Controller
{
    private string $matchingType = 'chat';
    public function __construct(private MatchingService $matchingService)
    {
    }

    public function index()
    {
        return Inertia::render('Matching/Chat/Index');
    }
    public function wait()
    {
    }

    public function cancel()
    {

    }

    public function connect()
    {
//        type 1 'date-chat', 2 'chat' , 3 'date-video', 4 'video'
        $result = ['status' => 200];
        try {
//            $result['data'] = $this->matchingService->connect();
            $this->matchingService->classifyByGender($this->matchingType);
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
