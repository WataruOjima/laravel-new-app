<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Comment; 
use Auth; 

class CommentsController extends Controller
{
    /**
     * バリデーション、登録データの整形など
     */
    public function store(CommentRequest $request)
    {
        $comment  = new Comment;
        $comment->comment = $request->comment;
        $comment->user_id = Auth::id();
        $comment->name = "";
        $comment->post_id = $request->post_id;
        $comment->save();
        return redirect()->route('bbs.show', [$comment['post_id']])->with('commentstatus','コメントを投稿しました');
    }
}


