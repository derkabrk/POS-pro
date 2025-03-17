<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BusinessCategory;
use App\Models\Plan;
use App\Models\Option;
use App\Models\Feature;
use App\Models\Testimonial;
use App\Models\PosAppInterface;

class WebController extends Controller
{
    public function index()
    {
        $page_data = get_option('manage-pages');
        $features = Feature::whereStatus(1)->latest()->get();
        $interfaces = PosAppInterface::whereStatus(1)->latest()->get();
        $testimonials = Testimonial::latest()->get();
        $recent_blogs = Blog::with('user:id,name')->whereStatus(1)->latest()->take(3)->get();
        $blogs = Blog::with('user:id,name')->whereStatus(1)->take(2)->get();
        $general = Option::where('key','general')->first();
        $plans = Plan::where('status',1)->latest()->get();
        $business_categories = BusinessCategory::latest()->get();

        return view('web.index', compact('page_data','features','interfaces','testimonials','recent_blogs','blogs','general','plans','business_categories'));
    }
}
