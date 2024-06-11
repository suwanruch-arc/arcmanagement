<?php

namespace App\Http\Controllers\Managements;

use App\Models\Shop;
use App\Traits\Search;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\FileServiceProvider;

class ShopController extends Controller
{
    use Search;
    public function fields($model = null)
    {

        $type = $model ? 'update' : 'create';
        $fields = [
            'type' => $type,
            'id' => $model->id ?? '',
            'has_template' => old('has_template') ?? $model->has_template ?? 'no',
            'name' => old('name') ?? $model->name ?? '',
            'keyword' => old('keyword') ?? $model->keyword ?? '',
            'tandc' => old('tandc') ?? $model->tandc ?? '',
            'status' => old('status') ?? $model->status ?? 'active',
        ];
        return $fields;
    }

    public function index()
    {
        $query = Shop::query();
        $query = Search::getData($query, [
            ['field' => 'name'],
            ['field' => 'email'],
            ['field' => 'username'],
            ['field' => 'contact_number'],
            ['field' => 'position'],
            ['field' => 'role'],
            ['field' => ['name', 'keyword'], 'ref' => 'partner'],
            ['field' => ['name', 'keyword'], 'ref' => 'department']
        ]);

        $data = $query->paginate(25);

        return view('manage.shops.index', compact('data'));
    }

    public function create()
    {
        return view('components.views.create', [
            'title' => 'ร้านค้า',
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


        DB::transaction(function () use ($validated, $request, &$shop) {
            $shop = new Shop;
            $shop->fill($validated);
            $shop->keyword = Str::upper($shop->keyword);
            $shop->created_by = Auth::id();
            $shop->updated_by = Auth::id();
            $shop->save();

            $id = $shop->id;
            $table = $shop->getTable();
            $path_shop = "shop/{$shop->keyword}";

            if ($request->hasFile('template')) {
                $file_template = $request->file('template');
                $field_template = 'template';

                $path_template = "{$path_shop}/template";
                FileServiceProvider::store($file_template, $path_template, $id, $table, $field_template);
            }

            if ($request->hasFile('banner')) {
                $file_banner = $request->file('banner');
                $field_banner = 'banner';

                $path_banner = "{$path_shop}/banner";
                FileServiceProvider::store($file_banner, $path_banner, $id, $table, $field_banner);
            }
        });

        $name = $shop->name;

        return redirect()->route('manage.shops.index')
            ->with('success', __('message.created', ['name' => $name]));
    }

    public function edit(Shop $shop)
    {
        return view('components.views.update', [
            'params' => ['shop' => $shop->id],
            'title' => 'ร้านค้า',
            'route' => 'manage.shops',
            'fields' => $this->fields($shop),
        ])->with(compact('shop'));
    }

    public function update(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'keyword' => 'required|min:3|max:3|unique:partners,id,' . $shop->id,
            'tandc' => 'nullable',
            'status' => 'required|in:active,inactive'
        ]);

        DB::transaction(function () use ($validated, $request, &$shop) {
            $shop->fill($validated);
            $shop->keyword = Str::upper($shop->keyword);
            $shop->updated_by = Auth::id();
            $shop->save();

            $id = $shop->id;
            $table = $shop->getTable();
            $path_shop = "shop/{$shop->keyword}";

            if ($request->hasFile('template')) {
                $file_template = $request->file('template');
                $field_template = 'template';

                $path_template = "{$path_shop}/template";
                FileServiceProvider::update($file_template, $path_template, $id, $table, $field_template);
            }

            if ($request->hasFile('banner')) {
                $file_banner = $request->file('banner');
                $field_banner = 'banner';

                $path_banner = "{$path_shop}/banner";
                FileServiceProvider::update($file_banner, $path_banner, $id, $table, $field_banner);
            }
        });

        $name = $shop->name;

        return redirect()->route('manage.shops.index')
            ->with('success', __('message.updated', ['name' => $name]));
    }

    public function destroy(Shop $shop)
    {
        $name = $shop->name;

        $shop->update(['status' => 'inactive']);

        return redirect()->route("manage.shops.index")->with('success', __('message.disabled', ['name' => $name]));
    }
}
