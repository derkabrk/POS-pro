<?php

namespace App\Http\Controllers;

use App\Models\Option;

class PolicyController extends Controller
{
    public function index()
    {
        $page_data = get_option('manage-pages');
        $general = Option::where('key','general')->first();
        $privacy_policy = Option::where('key', 'privacy-policy')->first();
        return view('web.policy.index',compact('page_data','general','privacy_policy'));
    }
}
