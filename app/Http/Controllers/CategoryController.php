<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use \Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category =  Category::all();
        return response ()->json([
            'Categorias' =>$category
        ],201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'descripcion' => 'required',
        ]);
        $category = new Category();
        $category ->descripcion = $request->input('descripcion');
        $category ->save();

        return response ()->json([
            'Categoria creada' =>$category
        ],201);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Category $category)
    {
        try {
            $category= Category::findorfail($request->id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response([
                    'status' => 'ERROR',
                    'error' => 'Categoria no encontrada'
                ], 404);
            }
        $this->validate($request, [
            'descripcion' => 'required',
            'id' => 'required'
        ]);
        $category ->descripcion = $request->input('descripcion');
        $category ->save();
        return response ()->json([
            'Categoria Actualizada' =>$category
        ],201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
        $category= Category::findorfail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'status' => 'ERROR',
                'error' => 'Categoria no encontrada'
            ], 404);
        }
        $category->delete();
        return response ()->json([
            'Categoria Borrada'
        ],201);
    }
}
