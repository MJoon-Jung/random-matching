<?php

namespace App\Domains\Matching\Controllers;

use App\Domains\Matching\Services\ChatMatchingService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatMatchingController extends Controller
{
    public function __construct(private ChatMatchingService $chatMatchingService)
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

    public function connect(Request $request)
    {
        /**
         * 각각 두가지의 연결이 있음 아무나 or 이성만
         * chat과 video는 애초에 다른 url로 옴
         * 아무나면 그냥 큰 set에 던진다.
         * 이성만이면 성별 확인
         * 그럼 제일 처음엔
         */
//        type 1 'date-chat', 2 'chat' , 3 'date-video', 4 'video'
        $type = (int) $request->query('type');
        $result = ['status' => 200];
        try {
//            $result['data'] = $this->matchingService->connect();
            $this->chatMatchingService->categorize($type);
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
