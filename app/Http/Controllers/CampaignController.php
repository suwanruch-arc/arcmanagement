<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\View\View;

class CampaignController extends Controller
{
    public function index(): View
    {
        $campaigns = Campaign::withTrashed()->search([
            ['field' => 'name'],
            ['field' => 'keyword'],
            ['field' => 'tandc'],
        ])->orderBy('status')->orderBy('name')->paginate(25);

        return view('site.campaigns.index')->with(compact('campaigns'));
    }
}
