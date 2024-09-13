<?php

namespace App\Http\Controllers\Managements;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Providers\FileServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    public function index(): View
    {
        $shops = Shop::withTrashed()->search([
            ['field' => 'name'],
            ['field' => 'keyword'],
            ['field' => 'tandc'],
        ])->orderBy('status')->orderBy('name')->paginate(25);

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

        foreach (['template', 'banner'] as $field) {
            if ($request->hasFile($field)) {
                $path = "shops/{$shop->keyword}";
                $file = FileServiceProvider::store($path, $shop, $field);
                $field_db = "{$field}_id";
                $shop->$field_db = $file->id;
                $shop->save();
            }
        }

        return redirect()->route('manage.shops.index')
            ->with('success', __('message.created', ['name' => $shop->name]));
    }

    public function show($id)
    {
        //
    }

    public function edit(Shop $shop)
    {
        $this->authorize('update', $shop);

        return view('manage.shops._form', [
            'model' => $shop,
        ]);
    }

    public function update(Request $request, Shop $shop)
    {
        $this->authorize('update', $shop);

        $validated = $request->validate([
            'name' => 'required|max:255',
            'keyword' => 'required|min:3|max:3|unique:shops,keyword,' . $shop->id,
            'tandc' => 'nullable',
        ]);

        foreach (['template', 'banner'] as $field) {
            if ($request->hasFile($field)) {
                $path = "shops/{$shop->keyword}";
                $file = FileServiceProvider::store($path, $shop, $field);
                $field_db = "{$field}_id";
                $shop->$field_db = $file->id;
                $shop->save();
            }
        }

        $shop->fill($validated);
        $shop->keyword = Str::upper($shop->keyword);
        $shop->save();

        return redirect()->route("manage.shops.index")
            ->with('success', __('message.updated', ['name' => $shop->name]));
    }

    public function destroy(Shop $shop)
    {
        $this->authorize('delete', $shop);

        $shop->status = 'inactive';
        $shop->save();
        $shop->delete();

        return redirect()->to(url()->previous())
            ->with('success', __('message.deleted', ['name' => $shop->name]));
    }

    public function restore(Request $request)
    {
        $id = $request->id;
        $shop = Shop::onlyTrashed()->find($id);
        if ($shop) {
            if ($shop->trashed()) {
                $shop->restore();
            }
            Shop::where('id', $id)->update(['status' => 'active']);

            return redirect()->to(url()->previous())
                ->with('success', __('message.restored', ['name' => $shop->name]));
        }

        return redirect()->to(url()->previous())
            ->with('error', __('message.update_failed'));
    }
}
