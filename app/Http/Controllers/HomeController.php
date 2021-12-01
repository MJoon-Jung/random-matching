<?php

namespace App\Http\Controllers;

use App\Domains\Matching\Models\Matching;
use App\Http\Resources\MatchingResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke()
    {
        if(request('lastId')) {
            return $this->findMatchingByLastId(request('lastId'));
        }
        $matchings = $this->findMatchingByLastId();
        return Inertia::render('Home', ["matchings" => $matchings]);
    }
    public function findMatchingByLastId(int $lastId=null)
    {
        return MatchingResource::collection(
            Matching::query()
                ->when($lastId, fn($builder) => $builder->where('id', '<', $lastId))
                ->latest('id')
                ->take(10)
                ->with(['man', 'woman'])
                ->get()
        );
    }
}
