<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Option;
use App\Models\Feature;

class AboutController extends Controller
{
    public function index()
    {
        $page_data = get_option('manage-pages');
        $general = Option::where('key','general')->first();
        $features = Feature::whereStatus(1)->latest()->get();
        $plans = Plan::where('status',1)->latest()->get();

        return view('web.about.index',compact('page_data','general','features','plans'));
    }
}
