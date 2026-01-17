<?php

namespace App\Http\Controllers\Api;

use App\Models\Roles;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Controllers\Controller;

class RolesApiController extends Controller
{
    public function index(Request $request)
    {
        $items = QueryBuilder::for(Roles::class)
            ->allowedFilters(['nombre'])
            ->allowedSorts(['id', 'created_at'])
            ->paginate();

        return response()->json($items);
    }

    public function store(Request $request)
    {
        $data = $request->validate(Roles::$rules);
        $item = Roles::create($data);

        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = Roles::findOrFail($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = Roles::findOrFail($id);
        $data = $request->validate(Roles::$rules);
        $item->update($data);

        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Roles::findOrFail($id);
        $item->delete();

        return response()->json(null, 204);
    }
}