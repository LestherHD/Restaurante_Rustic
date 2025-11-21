<?php

namespace App\Http\Controllers\Api;

use App\Models\CategoriaMenu;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Controllers\Controller;

class CategoriaMenuApiController extends Controller
{
    public function index(Request $request)
    {
        $items = QueryBuilder::for(CategoriaMenu::class)
            ->allowedFilters(['nombre'])
            ->allowedSorts(['id', 'created_at'])
            ->paginate();

        return response()->json($items);
    }

    public function store(Request $request)
    {
        $data = $request->validate(CategoriaMenu::$rules);
        $item = CategoriaMenu::create($data);

        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = CategoriaMenu::findOrFail($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = CategoriaMenu::findOrFail($id);
        $data = $request->validate(CategoriaMenu::$rules);
        $item->update($data);

        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = CategoriaMenu::findOrFail($id);
        $item->delete();

        return response()->json(null, 204);
    }
}