<?php

namespace App\Http\Controllers\Managements;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Department;
use App\Models\Privilege;

class StatusController extends Controller
{
    public function detail(Request $request)
    {
        $id = $request->id;
        $model = $request->model;
        $main = (object) ['id' => $id, 'table' => $model];
        switch ($model) {
            case 'partners':
                $departments = Partner::find($id)->departments()->pluck('id');
                $campaigns = Campaign::findMany($departments)->pluck('id');
                $privilege = Privilege::findMany($campaigns)->pluck('id');
                $data = [
                    'departments' => $departments,
                    'campaigns' => $campaigns,
                    'privileges' => $privilege,
                ];
                $title = 'การปิดการใช้งานพาร์ทเนอร์ดังกล่าว จะกระทบกับทุกดีพาร์ทเมนท์ ทุกแคมเปญและพรีวิลเลจต่างๆที่เกี่ยวของ กรุณายืนยันข้อมูลอีกครั้ง';
                break;

            case 'departments':
                $campaigns = Department::find($id)->campaigns()->pluck('id');
                $privilege = Privilege::findMany($campaigns)->pluck('id');
                $data = [
                    'campaign' => $campaigns,
                    'privilege' => $privilege,
                ];
                $title = 'การปิดการใช้งานดีพาร์ทเมนท์ดังกล่าว จะกระทบกับทุกแคมเปญและพรีวิลเลจต่างๆที่เกี่ยวของ กรุณายืนยันข้อมูลอีกครั้ง';
                break;
            case 'campaigns':
                $privilege = Campaign::find($id)->privileges()->pluck('id');
                $data = [
                    'privilege' => $privilege,
                ];
                $title = 'การปิดการใช้งานแคมเปญดังกล่าว จะกระทบกับทุกพรีวิลเลจที่เกี่ยวของ กรุณายืนยันข้อมูลอีกครั้ง';
                break;
            default:
                $data = [];
                $title = 'กรุณายืนยันข้อมูลอีกครั้ง';
                break;
        }
        return view('manage.status.detail')->with(compact('main'))->with(compact('data'))->with(compact('title'));
    }
    public function disable(Request $request)
    {
        $main_id = $request->mainId;
        $main_table = $request->mainTable;
        if ($request->data) {
            foreach ($request->data as $key => $item) {
                $table = $item['table'];
                $id = $item['id'];
                $array_id = json_decode($id, true);
                if ($array_id) {
                    $status = DB::table($table)->whereIn('id', $array_id)->update(['status' => 'inactive']);
                }
            }
        }
        DB::table($main_table)->where('id', $main_id)->update(['status' => 'inactive']);

        return response()->json(['status'=>'ok']);
    }
    public function reactive(Request $request)
    {
        dd($request->all());
    }
}
