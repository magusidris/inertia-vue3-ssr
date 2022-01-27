<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts from database
        $posts = Post::latest()->get();

        //render with data "posts"
        return Inertia::render('Post/Index', [
            'posts' => $posts
        ]);
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return Inertia::render('Post/Create');
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        // set validation
        $request->validate([
            'title'     => 'required',
            'content'   => 'required'
        ]);

        // create post
        $post = Post::create([
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        if($post) {
            return Redirect::route('post.index')->with('message', 'Data berhasil disimpan!');
        }
    }

    public function edit(Post $post)
    {
        return Inertia::render('Post/Edit', [
            'post'  => $post
        ]);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Post $post)
    {
        // set validation
        $request->validate([
            'title'     => 'required',
            'content'   => 'required'
        ]);

        // update post
        $post->update([
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        if ($post) {
            return Redirect::route('post.index')->with('message', 'Data berhasil diupdate!');
        }
    }

    public function destroy($id)
    {
        // find post by ID
        $post = Post::findOrFail($id);

        // delete post
        $post->delete();

        if($post) {
            return Redirect::route('post.index')->with('message', 'Data berhasil dihapus!');
        }
    }
}
