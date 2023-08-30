<?php

namespace App\Http\Controllers\Sites;

use App\Models\Shop;
use App\Models\Uniques;
use App\Models\Campaign;
use App\Models\Privilege;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Campaign $campaign)
    {
        $uniques = $campaign->uniques ?? [];

        return view('site.warehouse.index', compact('campaign'))->with(compact('uniques'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Campaign $campaign)
    {
        $shop_lists = Shop::whereIn('id', function ($query) use ($campaign) {
            $query->select('shop_id')
                ->from('privileges')
                ->where('campaign_id', $campaign->id);
        })->get(['id', 'name', 'keyword']);

        return view('site.warehouse._form', compact('campaign'))->with('shop_lists', $shop_lists);
    }

    public function checkFormat(Request $request)
    {
        $type = $request->type_split_data;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data_file =  explode("\n", File::get($file->getPathname()));
            foreach ($data_file as $key => $data) {
                $line = $key + 1;
                $split_data = explode($type, $data);
                if (count($split_data) < 5) {
                    $res['error'][$line] = 'Format ไฟล์ไม่ถูกต้อง';
                } else {
                    // list($mobile, $code, $shop, $value, $expire) = $split_data;
                }
            }
        } else {
            $res['error'] = 'ไม่พบไฟล์';
        }
        return response()->json($res);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(Warehouse $warehouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Warehouse $warehouse)
    {
        //
    }
}
