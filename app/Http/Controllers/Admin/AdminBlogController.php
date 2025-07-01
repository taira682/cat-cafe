<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AdminBlogController extends Controller
{
    // ブログ一覧画面
    public function index()
    {
        $blogs = Blog::all();
        return view('admin.blogs.index', ['blogs' => $blogs]);
    }

    // ブログ投稿画面
    public function create()
    {
        return view('admin.blogs.create');
    }

    // ブログ投稿処理
    public function store(StoreBlogRequest $request)
    {
        $savedImagePath = $request->file('image')->store('blogs', 'public');
        $blog = new Blog($request->validated());
        $blog->image = $savedImagePath;
        $blog->save();

        return to_route('admin.blogs.index')->with('success', 'ブログを投稿しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    // 指定したIDのブログ編集画面
    public function edit(string $id)
    {
        $blog = Blog::findOrfail($id);
        return view('admin.blogs.edit', ['blog' => $blog]);
    }

    // 指定したIDのブログ更新処理
    public function update(UpdateBlogRequest $request, string $id)
    {
        $blog = Blog::findOrfail($id);
        $updatedData = $request->validated();

        // 画像を更新する場合
        if($request->hasFile('image')) {
            // 変更前の画像を削除
            if($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            // 変更後の画像をアップロード、保存パスを更新対象データにセット
            $updatedData['image'] = $request->file('image')->store('blogs', 'public');
        }
        $blog->update($updatedData);

        return to_route('admin.blogs.index')->with('success', 'ブログを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
