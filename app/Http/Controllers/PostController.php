<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'posts' => Post::latest()->get() // Exemple de récupération de tous les posts
            // Ajoutez d'autres données ici
        ];
        return view('dashboard', $data);
    }

    public function showUserPosts($user_id)
    {
        $posts = Post::where('user_id', $user_id)->latest()->get();
        $userName = User::find($user_id)->name; // Récupère le nom de l'utilisateur
        return view('user_posts', ['posts' => $posts, 'userName' => $userName]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blogpost.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string','max:255'],
            'content' => ['required', 'string', 'max:255'],
            'picture' => ['file', 'mimes:jpg,png,gif', 'max:3072000'],
        ]);

        $picturePath = $request->file('picture')->storePublicly('public');
        
        Post::create([
            'title'=> $request->title,
            'content'=> $request->content,
            'picture'=> $picturePath,
            'user_id'=> Auth::user()->id,
        ]);

        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('blogpost.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
