<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use App\Traits\PartnerTrait;
use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\View\View;

class CampaignController extends Controller
{
    use PartnerTrait;
    public function index(): View
    {
        $campaigns = Campaign::withTrashed()->search([
            ['field' => 'name'],
            ['field' => 'keyword'],
            ['field' => 'tandc'],
        ])->orderBy('status')->orderBy('name')->paginate(25);

        return view('site.campaigns.index')->with(compact('campaigns'));
    }

    public function preCreate(): View
    {
        $partner_lists = $this->getPartnerLists();

        return view('site.campaigns.pre-create', ['partner_lists' => $partner_lists]);
    }

    public function create(Request $request): View
    {
        $template_type = $request->get('template_type');

        return view('site.campaigns._form', [
            'model' => null,
            'template_type' => $template_type
        ]);
    }
}
