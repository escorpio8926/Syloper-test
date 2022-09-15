<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\User;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) 
    {   
    $posts =  Post::select('posts.*','categories.descripcion as categoria')->join('categories', 'categories.id', '=', 'posts.categories_id')->where('user_id', $id)->paginate(5);
    return view('indice',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate($request, [
            'imagen' => 'required|image|mimes:jpeg,jpg|max:2048',
        ]);

        $path = $request->file('imagen')->getClientOriginalName();; //->store('public/uploads');
        $img = Image::make($request->file('imagen')); 
        $img->resize(100,100)->save(public_path().'/Uploads/'.$path);  zzz

        $post = new Post();
        $post ->titulo = $request->input('titulo');
        $post ->descripcion = $request->input('descripcion');
        $post ->user_id = $request->input('user_id');
        $post ->imagen ='Uploads/'.$path;
        $post ->slug =str_replace(" ", "-", $request->input('titulo'));
        $post ->categories_id = $request->input('categories_id');
        
        $post ->save();
       /*
        if (Request::wantsJson()) {
            // return JSON-formatted response
        } else {
            // return HTML response
        }
        */
        $categorys =  Category::all();
        return view('home',compact('categorys'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, $slug)
    {
        $post = Post::select('posts.*','categories.descripcion as categoria')->join('categories', 'categories.id', '=', 'posts.categories_id')->where('slug','=', $slug)->firstOrFail();
        $categorys =  Category::where('descripcion', '!=', $post->categoria)->get();
        return view('post',compact('post','categorys'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $post= Post::find($request->id);
        if($request->hasfile('imagen'))
        {
        $this->validate($request, [
        'imagen' => 'required|image|mimes:jpeg,jpg|max:2048',
        ]);
        $path = $request->file('imagen')->getClientOriginalName();; //->store('public/uploads');
        $img = Image::make($request->file('imagen')); 
        $img->resize(100,100)->save(public_path().'/Uploads/'.$path);
        $post ->imagen ='Uploads/'.$path;
        }

        $post ->titulo = $request->input('titulo');
        $post ->descripcion = $request->input('descripcion');
        $post ->user_id = $request->input('user_id');
        $post ->slug =str_replace(" ", "-", $request->input('titulo'));
        $post ->categories_id = $request->input('categories_id');
        $post ->save();

        $posts =  Post::select('posts.*','categories.descripcion as categoria')->join('categories', 'categories.id', '=', 'posts.categories_id')->where('user_id', $id)->paginate(5);
        return view('indice',compact('posts'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$user_id)
    {
        $post= Post::find($id);
        $post->delete();

        $posts =  Post::where('user_id', $user_id)->paginate(5);
        return view('indice',compact('posts'));
    }

    //RUTA DE LA API
    public function storeapi(Request $request)
    {   

        try {
            $user= User::findorfail($request->user_id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response([
                    'status' => 'ERROR',
                    'error' => 'Usuario no encontrado'
                ], 404);
            }

        try {
            $category= Category::findorfail($request ->categories_id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response([
                     'status' => 'ERROR',
                     'error' => 'Categoria no encontrada'
                   ], 404);
            }

        $this->validate($request, [
            'imagen' => 'required|image|mimes:jpeg,jpg|max:2048',
            'titulo' => 'required|min:1|max:100',
            'descripcion' => 'required|min:1|max:100',
            'categories_id' => 'required|min:1|max:100',
        ]);

        $path = $request->file('imagen')->getClientOriginalName();; //->store('public/uploads');
        $img = Image::make($request->file('imagen')); 
        $img->resize(100,100)->save(public_path().'/Uploads/'.$path);  

        $post = new Post();
        $post ->titulo = $request->input('titulo');
        $post ->descripcion = $request->input('descripcion');
        $post ->user_id = $request->input('user_id');
        $post ->imagen ='Uploads/'.$path;
        $post ->slug =str_replace(" ", "-", $request->input('titulo'));
        $post ->categories_id = $request->input('categories_id');
        
        $post ->save();
 
        return response ()->json([
            'Post Creado' =>$post
        ],201);
    }

    public function updateapi(Request $request)
    {

        try {
            $user= User::findorfail($request->user_id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response([
                    'status' => 'ERROR',
                    'error' => 'Usuario no encontrado'
                ], 404);
            }

        try {
            $category= Category::findorfail($request ->categories_id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response([
                     'status' => 'ERROR',
                     'error' => 'Categoria no encontrada'
                   ], 404);
            }

        try {
            $post= Post::findorfail($request->id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response([
                     'status' => 'ERROR',
                     'error' => 'Post no encontrado'
                   ], 404);
            }

        try {
            $post= Post::select('posts.*')->join('users', 'users.id', '=', 'posts.user_id')->where('user_id', $request->user_id)->where('posts.id', '=', $request->id)->firstOrFail();
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response([
                        'status' => 'ERROR',
                        'error' => 'El Post no pertenece al usuario'
                      ], 404);
           }
        $post= Post::find($request->id);

        $this->validate($request, [
            'titulo' => 'required|min:1|max:100',
            'descripcion' => 'required|min:1|max:100',
            'categories_id' => 'required|min:1|max:100',
        ]);

        if($request->hasfile('imagen'))
        {
        $this->validate($request, [
            'imagen' => 'required|image|mimes:jpeg,jpg|max:2048',
        ]);
        $path = $request->file('imagen')->getClientOriginalName();; //->store('public/uploads');
        $img = Image::make($request->file('imagen')); 
        $img->resize(100,100)->save(public_path().'/Uploads/'.$path);
        $post ->imagen ='Uploads/'.$path;
        }


        $post ->titulo = $request->input('titulo');
        $post ->descripcion = $request->input('descripcion');
        $post ->user_id = $request->input('user_id');
        $post ->slug =str_replace(" ", "-", $request->input('titulo'));
        $post ->categories_id = $request->input('categories_id');
        $post ->save();

        return response ()->json([
            'Post Actualizado' =>$post
        ],201);
    }

    public function destroyapi(Request $request)
    {
        try {
            $user= User::findorfail($request->user_id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response([
                    'status' => 'ERROR',
                    'error' => 'Usuario no encontrado'
                ], 404);
            }

        try {
            $post= Post::findorfail($request->id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response([
                     'status' => 'ERROR',
                     'error' => 'Post no encontrado'
                   ], 404);
            }

        try {
            $post= Post::select('posts.*')->join('users', 'users.id', '=', 'posts.user_id')->where('user_id', $request->user_id)->where('posts.id', '=', $request->id)->firstOrFail();
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response([
                        'status' => 'ERROR',
                        'error' => 'El Post no pertenece al usuario'
                        ], 404);
            }

        $post= Post::find($request->id);
        $post->delete();

        return response ()->json([
            'Post Eliminado' =>$post
        ],201);
    }

    public function all() 
    { 
    $posts =  Post::all();  
    return response ()->json([
        'Listado de Posts' =>$post
    ],201);
    }
}
