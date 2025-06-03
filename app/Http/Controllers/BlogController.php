<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Option;
use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index()
    {
        $page_data = get_option('manage-pages');
        $recent_blogs = Blog::with('user:id,name')->whereStatus(1)->latest()->take(3)->get();
        $blogs = Blog::with('user:id,name')->whereStatus(1)->take(10)->get();
        $general = Option::where('key','general')->first();

        return view('web.blog.index', compact('recent_blogs', 'blogs', 'page_data','general'));
    }

    public function show(string $slug)
    {
        $page_data = get_option('manage-pages');
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $recent_blogs = Blog::with('user:id,name')->select('id', 'title', 'slug', 'image', 'user_id', 'created_at', 'updated_at')->whereStatus(1)->latest()->limit(3)->get();
        // Fetch only top-level comments, eager load replies recursively and likes
        $comments = Comment::with(['replies.replies', 'likes', 'replies.likes'])
            ->whereStatus(1)
            ->where('blog_id', $blog->id)
            ->whereNull('comment_id')
            ->latest()
            ->get();
        $general = Option::where('key','general')->first();
        return view('web.blog.show', compact('page_data','blog', 'recent_blogs','comments','general'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'comment' => 'required|string|max:255',
            'blog_id' => 'required|integer|exists:blogs,id',
            'comment_id' => 'nullable|integer|exists:comments,id',
        ]);
        Comment::create($request->only(['name', 'email', 'comment', 'blog_id', 'comment_id']));
        return response()->json([
            'message'   => __('Your Comment Submitted successfully'),
            'redirect'  => route('blogs.show', $request->blog_slug)
        ]);
    }

    public function likeComment(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|integer|exists:comments,id',
        ]);
        $userId = Auth::id();
        $ip = $request->ip();
        $like = CommentLike::where('comment_id', $request->comment_id)
            ->when($userId, function($q) use ($userId) { $q->where('user_id', $userId); })
            ->when(!$userId, function($q) use ($ip) { $q->where('ip_address', $ip); })
            ->first();
        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            CommentLike::create([
                'comment_id' => $request->comment_id,
                'user_id' => $userId,
                'ip_address' => $userId ? null : $ip,
            ]);
            $liked = true;
        }
        $count = CommentLike::where('comment_id', $request->comment_id)->count();
        return response()->json([
            'success' => true,
            'liked' => $liked,
            'count' => $count
        ]);
    }
}
