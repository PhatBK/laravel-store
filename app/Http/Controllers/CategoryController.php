<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\Storage;
use Auth;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $categories = Category::paginate(config('custom.products_paginate'));
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if( Auth::user()->cannot('create_categories'), 403);
        $categories = Category::all();
        return view('categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if( Auth::user()->cannot('create_categories'), 403);
        $arrToValidate = [
            'name'          => 'required|string|max:255|unique',
            'title'         => 'required|string|max:255|unique',
            'description'   => 'string|max:255',
            'image'         => 'image',
            'visible'          => 'required|boolean',
            'parent_id'     => 'required|integer|max:255',
        ];

        $category = Category::create([
            'name'            => request('name'),
            'title'           => request('title'),
            'description'     => request('description'),
            'visible'            => request('visible'),
            'parent_id'       => request('parent_id'),
            'added_by_user_id' => Auth::user()->id,
        ]);

        if ( request()->file('image') ) {

            $image = request()->file('image');
            $directory = 'public/images/categories/' . $category->id;
            $filename = $image->getClientOriginalName();
    
            if ( !Storage::makeDirectory($directory)
                or !Storage::putFileAs($directory, $image, $filename )
                or !$category->update(['image' => $filename])
            ) {
                return back()->withErrors(['something wrong. err' . __line__])->withInput();
            }
        }

        return redirect()->route('categories.show', ['category' => $category->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category) {
        if( Auth::user() and  Auth::user()->can(['view_products'])) {
            $paginator = Product::where('category_id', '=', $category->id)->paginate(config('custom.products_paginate'));
        } else {
            $paginator = Product::where('category_id', '=', $category->id)->where('visible', '=', 1)->paginate(config('custom.products_paginate'));
        }
        
        return view('categories.show', compact('category', 'paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        abort_if (Auth::user()->cannot('edit_categories'), 403);
        $categories = Category::all();
        return view('categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category)
    {
        abort_if( Auth::user()->cannot('edit_categories'), 403);

        $validator = request()->validate([
            'name'          => 'required|string|max:255',
            'title'         => 'required|string|max:255',
            'description'   => 'string|max:255',
            'image'         => 'image',
            'visible'          => 'required|boolean',
            'parent_id'     => 'required|integer|max:255',
        ]);

        $category->update([
            'name'              => request('name'),
            'title'             => request('title'),
            'description'       => request('description'),
            'visible'              => request('visible'),
            'parent_id'         => request('parent_id'),
            'edited_by_user_id' => Auth::user()->id,
        ]);

        if ( request()->file('image') ) {

            $image = request()->file('image');
            $directory = 'public/images/categories/' . $category->id;
            $filename = $image->getClientOriginalName();
    
            // if ( Storage::makeDirectory($directory) ) {
            //     if ( Storage::putFileAs($directory, $image, $filename )) {
            //         if ( $category->update('image' => $filename )) {
            //             return redirect()->route('category.show', ['category' => $category->id]);
            //         }
            //     }
            // }
            if ( !Storage::makeDirectory($directory)
                or !Storage::putFileAs($directory, $image, $filename )
                or !$category->update(['image' => $filename])
            ) {
                return back()->withErrors(['something wrong. err' . __line__])->withInput();
            }
        }

        return redirect()->route('categories.show', ['category' => $category->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        abort_if ( Auth::user()->cannot('delete_categories'), 403 );
        if ( $category->id == 1 ) {
            return back()->withErrors(['"' . $category->name . '" is basic category and can not be removed.']);
        }
        
        if ( $category->products->count() ) {
            foreach ( $category->products as $product ) {
                $product->update([
                    'category_id' => 1,
                ]);
            }
        }

        $category->delete();
        return redirect()->route('categories.index');
    }

}
