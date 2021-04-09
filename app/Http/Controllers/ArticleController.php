<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // index 페이지
        // created_at desc 후 15개씩 호출 (페이징처리)
        $articles = Article::orderBy('created_at', 'desc')->paginate(15);
        return view('article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 글쓰기 폼
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 글쓰기 후 저장
        $board = $this->validateArticle();
        $board['user_id'] = auth()->user()->id;
        $board['user_name'] = auth()->user()->name;

        if ($request->hasFile('image')) {
            $fileName = time(). '_'. $request->file('image')->getClientOriginalName();
            $filePath = $request->file('image')->storeAs('public/images', $fileName);
            $board['image_name'] = $fileName;
            $board['image_path'] = $filePath;
        }

        Article::create($board);

        return redirect()->route('article.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $comment = Comment::where('article_id', '=', $article->id)->orderBy('created_at', 'desc')->get();
        return view('article.show', compact('article', 'comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $authCheck = Gate::allows('update-post', $article);
        return $authCheck ? view('article.edit', compact('article')) : $this->failedAccessArticle();

        // $authCheck = Gate::inspect('article-auth-check', $article);
        // return $authCheck->allowed() ? view('article.edit', compact('article')) : $this->failedAccessArticle();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $authCheck = Gate::allows('update-post', $article);

        if (!$authCheck) {
            return $this->failedAccessArticle();
        }
        
        $article->update($this->validateArticle());
        return redirect()->route('article.show', $article->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $authCheck = Gate::allows('update-post', $article);

        if (!$authCheck) {
            return $this->failedAccessArticle();
        }

        $article->delete();
        return redirect()->route('article.index');
    }
    
    protected function validateArticle(){
        return request()->validate([
            'title' => 'required',
            'content' => 'required'
        ]);
    }

    public function failedAccessArticle() {
        return redirect()->route('article.index')->with('message', '작성자가 아닙니다.');
    }
}
