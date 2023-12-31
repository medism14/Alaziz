<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Http\Requests\MenuStoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.menus.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuStoreRequest $request)
    {

        $image = $request->file('image')->store('public/menus');

        $menu = Menu::create([
            'name' => $request->name,
            'image' => $image,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        if ($request->has('categories'))
        {
            $menu->categories()->attach($request->categories);
        }   

        return to_route('admin.menus.index')->with('success', 'Menu créé avec succès');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $categories = Category::all();
        return view('admin.menus.edit', compact('menu','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
        ],[
            'name.required' => 'le champ Nom est obligatoire',
            'price.required' => 'le champ Prix est obligatoire',
            'description.required' => 'le champ description est obligatoire',
        ]
        );

        $image = $menu->image;

        if ($request->hasFile('image'))
        {
            Storage::delete($menu->image);
            $image = $request->file('image')->store('public/menus');
        }

        if ($request->has('categories'))
        {
            $menu->categories()->sync($request->categories);
        }

        $menu->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $image,
        ]);

        return to_route('admin.menus.index')->with('success', 'Menu modifié avec succès');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        Storage::delete($menu->image);
        $menu->delete();

        return to_route('admin.menus.index')->with('danger', 'Menu supprimé avec succès');
    }
}
