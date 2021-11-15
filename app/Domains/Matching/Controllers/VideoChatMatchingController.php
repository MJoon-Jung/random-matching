<?php

namespace App\Domains\Matching\Controllers;

use App\Domains\Matching\Services\MatchingService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VideoChatMatchingController extends Controller
{
    private string $matchingType = 'video';
    public function __construct(private MatchingService $videoMatchingService)
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

    public function connect(int $genderType)
    {
        $result = ['status' => 200];
        try {
//            $result['data'] = $this->videoMatchingService->connect();
            $this->videoMatchingService->connect($genderType, $this->matchingType);
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
