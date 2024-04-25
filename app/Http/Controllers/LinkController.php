<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $links = QueryBuilder::for(Link::class)
            ->allowedFilters(['full_link', 'short_link'])
            ->allowedSorts(['full_link', 'short_link', 'views', 'id'])
            ->where('user_id', Auth::user()->id)
            ->paginate($request->get('perPage', 5));
        return response()->json($links);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLinkRequest $request)
    {
        $link = new Link([
            'short_link' => $request->short_link,
            'full_link' => $request->full_link,
            'user_id' => Auth::user()->id,
            'views' => 0,
        ]);
        $link->save();
        return response()->json($link, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        return response()->json($link);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLinkRequest $request, Link $link)
    {
        $link->full_link = $request->full_link;
        $link->short_link = $request->short_link;
        $link->save();
        return response()->json($link);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        $link->delete();
        return response()->noContent();
    }
}
