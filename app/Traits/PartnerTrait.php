<?php

namespace App\Traits;

use App\Models\Partner;

trait PartnerTrait
{
    public function getPartnerLists()
    {
        $partners = Partner::with([
            'departments' => function ($query) {
                $query->where('status', 'active');
            }
        ])->get();

        $partner_lists = $partners->mapWithKeys(function ($partner) {
            $departments = $partner->departments->mapWithKeys(function ($department) {
                return [$department->id => $department->name];
            });

            return [$partner->name => $departments];
        })->toArray();

        return $partner_lists;
    }
}
