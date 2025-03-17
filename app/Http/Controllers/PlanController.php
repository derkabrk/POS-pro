<?php

namespace App\Http\Controllers;

use App\Models\BusinessCategory;
use App\Models\Plan;
use App\Models\Option;

class PlanController extends Controller
{
    public function index()
    {
        $page_data = get_option('manage-pages');
        $general = Option::where('key','general')->first();
        $plans = Plan::where('status',1)->latest()->get();
        $business_categories = BusinessCategory::latest()->get();

        return view('web.plan.index',compact('page_data', 'general','plans', 'business_categories'));
    }
}
