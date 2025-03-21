<?php

namespace App\Http\Controllers\Admin;

use App\Models\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class AcnooTermConditionController extends Controller
{
    public function index()
    {
        $term_condition = Option::where('key', 'term-condition')->first();
        return view('admin.settings.term-condition.index', compact('term_condition'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'term_title' => 'required|string',
            'description_one' => 'required|string',
            'description_two' => 'required|string',
        ]);

       Option::updateOrCreate(
            ['key' => 'term-condition'],
            ['value' => [
                'term_title' => $request->term_title,
                'description_one' => $request->description_one,
                'description_two' => $request->description_two
            ]]
        );

        Cache::forget('term-condition');
        return response()->json(__('Term And Condition updated successfully.'));
    }
}
