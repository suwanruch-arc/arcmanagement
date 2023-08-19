<?php

namespace App\Http\Controllers\Managements;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function fields($model = null)
    {

        $type = $model ? 'update' : 'create';
        $fields = [
            'type'         => $type,
            'id' => $model ? $model->id : '',
            'has_template' => old('has_template') ?? ($model->has_template ?? 'no'),
            'name'         => old('name') ?? ($model ? $model->name : ''),
            'keyword'      => old('keyword') ?? ($model ? $model->keyword : ''),
            'tandc'        => old('tandc') ?? ($model ? $model->tandc : '<p>asdasdasdasdsadasd</p>'),
            'status'       => old('status') ?? ($model ? $model->status : 'active'),
        ];
        return $fields;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::all();

        return view('manage.shops.index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('components.views.create', [
            'title' => 'Shop',
            'route' => 'manage.shops',
            'fields' => $this->fields(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'keyword' => 'required|min:3|max:3|unique:shops',
            'tandc' => 'nullable',
            'status' => 'required|in:active,inactive'
        ]);

        $shop = new Shop;
        $shop->fill($validated);
        $shop->created_by = Auth::id();
        $shop->updated_by = Auth::id();
        $shop->save();

        $name = $shop->name;

        return redirect()->route('manage.shops.index')
            ->with('success', __('message.created', ['name' => $name]));
    }
}
