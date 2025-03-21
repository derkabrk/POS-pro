<?php

namespace App\Http\Controllers;

use App\Models\Option;

class TermServiceController extends Controller
{
    public function index()
    {
        $page_data = get_option('manage-pages');
        $general = Option::where('key','general')->first();
        $term_condition = Option::where('key', 'term-condition')->first();
        return view('web.term.index',compact('page_data','general','term_condition'));
    }
}
