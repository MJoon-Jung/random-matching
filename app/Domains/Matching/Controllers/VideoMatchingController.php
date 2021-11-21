<?php

namespace App\Domains\Matching\Controllers;

use App\Domains\Matching\Services\MatchingService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class VideoMatchingController extends Controller
{
    public function __construct(private MatchingService $matchingService)
    {
    }

    public function index()
    {
        return Inertia::render('Matching/Video/Index');
    }
    public function wait()
    {
    }

    public function cancel()
    {

    }

    public function connect(Request $request)
    {
        $result = ['status' => 200];
        try {
            $result['message'] = $this->matchingService->classifyByGender($request->type);
        } catch (\Exception $e) {
            $result = [
                'error' =>  $e->getMessage(),
                'status' => 500,
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
