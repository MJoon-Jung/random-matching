<?php

namespace App\Domains\Matching\Controllers;

use App\Domains\Matching\Models\Matching;
use App\Domains\Matching\Services\MatchingService;
use App\Http\Controllers\Controller;
use App\Http\Resources\MatchingResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MatchingController extends Controller
{
    public function __construct(private MatchingService $matchingService){}

    public function index()
    {
        return Inertia::render('Matching/Index');
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
}
