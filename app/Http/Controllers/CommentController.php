<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }
    
    // 댓글 저장
    public function store() 
    {
        $comment = $this->validateComment();
        $comment['user_id'] = auth()->user()->id;
        $comment['user_name'] = auth()->user()->name;

        Comment::create($comment);

        return redirect()->back()->with('comment_message', '댓글이 정상적으로 등록되었습니다.');
    }

    protected function validateComment(){
        return request()->validate([
            'article_id' => 'required',
            'comment' => 'required|max:255'
        ]);
    }
}
