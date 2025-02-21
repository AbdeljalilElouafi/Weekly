<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostsRequest;
use App\Http\Requests\UpdatePostsRequest;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Posts::paginate(10); 
        return view('posts.index', compact('posts'));
    }

    
    public function create()
    {
        $categories = Category::all();
        // dd($categories); 
        return view('posts.create', compact('categories'));
    }

    public function welcome()
    {
        $posts = Posts::with('category')
                    ->where('status', 'active')
                    ->latest()
                    ->paginate(9);
                    
        return view('welcome', compact('posts'));
    }

    
    public function store(StorePostsRequest $request)
    {
        $post = new Posts([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image ? $request->file('image')->store('images', 'public') : null,
            'status' => $request->status,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
        ]);

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    
    public function edit(Posts $post)
    {
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    
    public function update(UpdatePostsRequest $request, Posts $post)
    {
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image ? $request->file('image')->store('images') : $post->image, 
            'status' => $request->status,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    
    public function destroy(Posts $post)
    {
        $post->delete(); 
        return redirect()->route('posts.index')->with('success', 'Post moved to trash.');
    }

    
    public function restore($id)
    {
        $post = Posts::withTrashed()->findOrFail($id);
        $post->restore();
        return redirect()->route('posts.index')->with('success', 'Post restored successfully.');
    }

    
    public function forceDelete($id)
    {
        $post = Posts::withTrashed()->findOrFail($id);
        $post->forceDelete();
        return redirect()->route('posts.index')->with('success', 'Post permanently deleted.');
    }


    public function trashed()
    {
        
        $posts = Posts::onlyTrashed()->paginate(10);

        return view('posts.trashed', compact('posts'));
    }


    public function show(Posts $post)
    {
        $post->load(['comments.user', 'category']);
        return view('posts.show', compact('post'));
    }

    public function like(Posts $post)
    {
        $post->likes()->create([
            'user_id' => auth()->id()
        ]);
        
        return back();
    }

    public function unlike(Posts $post)
    {
        $post->likes()->where('user_id', auth()->id())->delete();
        
        return back();
    }



}
