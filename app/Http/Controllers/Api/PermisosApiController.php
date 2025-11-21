<?php

namespace App\Http\Controllers\Api;

use App\Models\Permisos;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Controllers\Controller;

class PermisosApiController extends Controller
{
    public function index(Request $request)
    {
        $items = QueryBuilder::for(Permisos::class)
            ->allowedFilters(['nombre'])
            ->allowedSorts(['id', 'created_at'])
            ->paginate();

        return response()->json($items);
    }

    public function store(Request $request)
    {
        $data = $request->validate(Permisos::$rules);
        $item = Permisos::create($data);

        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = Permisos::findOrFail($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = Permisos::findOrFail($id);
        $data = $request->validate(Permisos::$rules);
        $item->update($data);

        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Permisos::findOrFail($id);
        $item->delete();

        return response()->json(null, 204);
    }
}