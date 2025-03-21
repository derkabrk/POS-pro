<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class AcnooMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:messages-read')->only('index');
        $this->middleware('permission:messages-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $messages = Message::latest()->paginate(20);
        return view('admin.messages.index', compact('messages'));
    }

    public function acnooFilter(Request $request)
    {
        $messages = Message::when(request('search'), function ($q) {
            $q->where(function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('phone', 'like', '%' . request('search') . '%')
                    ->orWhere('email', 'like', '%' . request('search') . '%')
                    ->orWhere('company_name', 'like', '%' . request('search') . '%')
                    ->orWhere('message', 'like', '%' . request('search') . '%');
            });
        })
            ->latest()
            ->paginate($request->per_page ?? 20);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('admin.messages.datas', compact('messages'))->render()
            ]);
        }

        return redirect(url()->previous());
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return response()->json([
            'message'   => __('Message deleted successfully'),
            'redirect'  => route('admin.messages.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        Message::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message' => __('Selected Mesages deleted successfully'),
            'redirect' => route('admin.messages.index')
        ]);
    }
}
