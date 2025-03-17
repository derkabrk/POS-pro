<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class AcnooCommentController extends Controller
{
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json([
            'message' => __('Comment deleted successfully.'),
            'redirect' => route('admin.blogs.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        Comment::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message' => __('Selected Comments deleted successfully'),
            'redirect' => route('admin.blogs.index')
        ]);
    }
}
