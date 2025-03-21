<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:notifications-read')->only('mtIndex');
    }

    public function mtIndex()
    {
          $notifications = auth()->user()->notifications()
            ->whereDate('created_at', today())
            ->latest()
            ->get();
        return view('admin.notifications.index', compact('notifications'));
    }

    public function acnooFilter(Request $request)
    {
        $notifications = Notification::whereDate('created_at', today())->latest()->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('admin.notifications.datas', compact('notifications'))->render()
            ]);
        }

        return redirect(url()->previous());
    }

    public function mtView($id)
    {
        $notify = Notification::find($id);
        if ($notify) {
            $notify->read_at = now();
            $notify->save();
            return redirect($notify->data['url'] ?? '/');
        }

        return back()->with('error', __('Premission denied.'));
    }

    public function mtReadAll()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        return back();
    }

}
