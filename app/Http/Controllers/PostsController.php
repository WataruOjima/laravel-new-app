<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth; 
use App\Http\Requests\PostRequest;
use Image;
use Intervention\Image\ImageManagerStatic;
use Storage;

class PostsController extends Controller
{
    /**
     * 投稿一覧表示アクション
     */
    public function index(Request $request)
    {
        #$searchword = $request->searchword;
        $searchword = $request->searchword;
        #dd($searchword);

        $posts = Post::with(['comments', 'category']) # クエリーの調整 N+1 問題解消
            ->orderBy('created_at', 'desc')
            ->fuzzyNameMessage($searchword)
            ->paginate(10); 
        
        return view('bbs.index', [ 
            'posts' => $posts,
            'searchword' => $searchword
        ]);
    }

    /**
    * 詳細
    */
    public function show(Request $request, $id)
    {
        $user = auth()->user();
        $post = Post::findOrFail($id);

        return view('bbs.show', compact('post'));
    }
    /**
    * 投稿フォーム
    */
    public function create()
    {
        return view('bbs.create');
    }

    /**
    * バリデーション、登録データの整形など
    */
    public function store(PostRequest $request)
    {

        $image_file = "";
        $upload_image = $request->file('image_file');

        if ($upload_image) {
            //$path = $upload_image->store('uploads', 'public');
            $path = Storage::disk('s3')->put('/', $upload_image, 'public');
            if ($path) {
                //Image::make($upload_image->getRealPath())->resize(150, 150)->save();
                $image = Image::make($upload_image->getRealPath());
                $image->resize(150, 150);
                $image->path = Storage::disk('s3')->url($path);
                $image->save();
                $image_file = $path;
            }
        }


        $post  = new Post;
        $post->subject = $request->subject;
        $post->message = $request->message;
        $post->image_file = $image_file;
        $post->name = "";
        $post->user_id = Auth::id();
        $post->save();
        return redirect('/bbs')->with('poststatus', '新規投稿しました');
    }

    /**
     * 編集フォーム
     */
    public function edit($id)
    {
        // update, destroyでも同様に
        $post = Post::findOrFail($id);
        $this->authorize('edit', $post);
        return view('bbs.edit',['post' => $post]);
    }

    /**
     * 編集機能実行
     */
    public function update(PostRequest $request, $id)
    {

        $image_file = "";
        $upload_image = $request->file('image_file');

        if ($upload_image) {
            //$path = $upload_image->store('uploads', 'public');
            $path = Storage::disk('s3')->put('/', $upload_image, 'public');
            if ($path) {
                //Image::make($upload_image->getRealPath())->resize(150, 150)->save();
                $image = Image::make($upload_image->getRealPath());
                $image->resize(150, 150);
                $image->path = Storage::disk('s3')->url($path);
                $image->save();
                $image_file = $path;
            }
        }
        
    $post = Post::findOrFail($id);
    $post->subject = $request->subject;
    $post->message = $request->message;
    $post->image_file = $image_file;
    $post->name = "";
    $post->user_id = Auth::id();
    $post->save();
  
    return redirect('/bbs')->with('poststatus', '投稿を編集しました');
    }

    /**
     * 削除機能
     */
    public function destroy($id)
    {
    $post = Post::findOrFail($id);
    
    $post->comments()->delete(); // コメント削除実行
    $post->delete();  // 投稿削除実行
    
    return redirect('/bbs')->with('poststatus', '投稿を削除しました');
    }

}
