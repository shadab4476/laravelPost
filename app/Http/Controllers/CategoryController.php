<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Nette\Utils\Html;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (request()->ajax()) {
            $categories = Category::get();
            $category_table =   DataTables::of($categories)->addColumn("name", function ($row) {
                if ($row->name) {
                    return Html::fromHtml('<a class="underline" href="' . route('category.posts.show', $row->id) . '">' . $row->name . '</a>');
                }
                return;
            })->addColumn("action", function ($row) {
                $edit = route('categories.edit', $row->id);
                $delete = route('categories.destroy', $row->id);
                $htmlString = '<div><ul class="flex justify-evenly items-center">';
                $htmlString .= '<li><a class="px-1" href="' . $edit . '">Edit</a></li>';
                $htmlString .= '<li><button delete-data="' . $delete . '" class="delete_category px-1">Delete</button></li>';
                $htmlString .= '</ul></div>';
                return Html::fromHtml($htmlString);
            });
            return $category_table->make(true);
        }
        return view("category.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            "name" => "required|unique:categories,name",
        ]);
        Category::create([
            "name" => $request->input('name'),
        ]);
        return redirect()->route('categories.index')->with(["status" => "Category Created."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category_show_route = route('category.posts.show', $id);
        $category = Category::find($id);
        if (request()->ajax()) {
            return  DataTables::of($category->posts)->make(true);
        }
        return view('category.view', compact('category_show_route'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $category = Category::find($id);
        return view("category.edit", compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            "name" => "required",
        ]);
        $category = Category::find($id);
        $category_names = Category::get(["name"]);
        foreach ($category_names as $category_name) {
            if (strtolower($category->name) != strtolower($request->input('name')) && strtolower($category_name->name) == strtolower($request->input('name'))) {
                return redirect()->back()->with(["error" => "This name already existed"]);
            }
        }
        $category->name = $request->input('name');
        $category->update();
        return redirect()->route('categories.index')->with(["status" => "Category updated."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json([
                "status" => "Category deleted."
            ]);
        }
    }
}
