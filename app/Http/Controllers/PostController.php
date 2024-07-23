<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PostController extends Controller implements HasMiddleware
{
    # ajout d'un middleware au controller
    # except: retirer certaines routes du middleware
    public static function middleware(){
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts = Post::all();
        return ['message' => 'get all ok','datas' => $posts];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $fields = $request->validate([
            'title' => 'required|max:200',
            'body' => 'required',
        ]);

        # crée le post directement à partir de l'utilisateur connecté
        $post = $request->user()->posts()->create($fields);
        return ['message' => 'store ok','datas' => $post];
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
        return ['message' => 'show ok','datas' => $post];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
        $fields = $request->validate([
            'title' => 'required|max:200',
            'body' => 'required',
        ]);

        $post->update($fields);
        return ['message' => 'update ok','datas' => $post];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
        $post->delete();
        return ['message' => 'delete ok','datas' => []];
    }
}
