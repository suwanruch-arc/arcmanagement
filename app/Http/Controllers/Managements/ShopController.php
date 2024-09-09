<?php

namespace App\Http\Controllers\Managements;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Traits\Search;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    use Search;

    public function index(): View
    {
        $query = Shop::query()->withTrashed();
        $query = Search::getData($query, [
            ['field' => 'name'],
            ['field' => 'keyword'],
            ['field' => 'tandc'],
        ]);

        $shops = $query->orderBy('status')->orderBy('name')->paginate(25);

        return view('manage.shops.index', compact('shops'));
    }
    
    public function create(): View
    {
        $this->authorize('create');

        return view('manage.shops._form', [
            'model' => null,
        ]);
    }
    
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'keyword' => 'required|min:3|max:3|unique:shops',
            'tandc' => 'nullable',
        ]);

        $shop = new Shop;
        $shop->fill($validated);
        $shop->keyword = Str::upper($shop->keyword);
        $shop->save();

        return redirect()->route('manage.shops.index')
            ->with('success', __('message.created', ['name' => $shop->name]));
    }
    
    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {
        //
    }
    
    public function update(Request $request, $id)
    {
        //
    }
    
    public function destroy($id)
    {
        //
    }
}
