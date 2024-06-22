<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Nette\Utils\Html;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
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
            $data = Post::get();
            $dataTable = DataTables::of($data)->addColumn("category", function ($row) {
                if ($row->category->name) {
                    $route_show = route("posts.category.show", $row->category->id);
                    $linkCategory = '<a class="underline" href="' . $route_show . '">' . $row->category->name . '</a>';
                    return Html::fromHtml($linkCategory);
                }
                return;
            })->addColumn("action", function ($row) {
                $delete =   route('posts.destroy', $row->id);
                $show = route('posts.show', $row->id);
                $edit = route('posts.edit', $row->id);

                $htmlAddAction = '<div><ul class="flex justify-evenly items-center">';
                $htmlAddAction .= '<li><a class="px-1" href="' . $show . '">View</a></li>';
                $htmlAddAction .= '<li><a class="px-1" href="' . $edit . '">Edit</a></li>';
                $htmlAddAction .= '<li><button delete-data="' . $delete . '" class="delete_post px-1">Delete</button></li>';
                $htmlAddAction .= '</ul></div>';
                return Html::fromHtml($htmlAddAction);
            });
            return $dataTable->make(true);
        }
        return view("posts.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::get(["name", "id"]);
        return view("posts.create", compact('categories'));
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
            "name" => "required|unique:posts,name|string|max:15",
            "content" => "required",
            "category_id" => "required",
        ]);

        Post::create([
            "name" => $request->input('name'),
            "content" => $request->input('content'),
            "category_id" => $request->input('category_id'),
        ]);

        return redirect()->route('posts.index')->with(["status" => "Posts Created Successfully."]);
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
        $post = Post::find($id);
        return view("posts.view", compact('post'));
    }

    public function postCategory($category_id)
    {
        $category_id_data = route('posts.category.show', $category_id);
        if (request()->ajax()) {
            $posts = Post::whereCategory_id($category_id)->get();
            $dataTable = DataTables::of($posts)->addColumn("category", function ($row) {
                if ($row->category->name) {
                    $route_show = route("posts.category.show", $row->category->id);
                    $linkCategory = '<a class="underline" href="' . $route_show . '">' . $row->category->name . '</a>';
                    return Html::fromHtml($linkCategory);
                }
                return;
            })->addColumn("action", function ($row) {
                $delete =   route('posts.destroy', $row->id);
                $show = route('posts.show', $row->id);
                $edit = route('posts.edit', $row->id);

                $htmlAddAction = '<div><ul class="flex justify-evenly items-center">';
                $htmlAddAction .= '<li><a class="px-1" href="' . $show . '">View</a></li>';
                $htmlAddAction .= '<li><a class="px-1" href="' . $edit . '">Edit</a></li>';
                $htmlAddAction .= '<li><button delete-data="' . $delete . '" class="delete_post px-1">Delete</button></li>';
                $htmlAddAction .= '</ul></div>';
                return Html::fromHtml($htmlAddAction);
            });;
            return $dataTable->make(true);
        }
        return view("posts.category_post_show", compact('category_id_data'));
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
        $categories = Category::get();
        $post = Post::find($id);
        return view("posts.edit", compact('post', 'categories'));
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
            "name" => "required|string|max:15",
            "content" => "required",
            "category_id" => "required",
        ]);
        $post = Post::find($id);
        $post_names = Post::get(["name"]);
        foreach ($post_names as $post_name) {
            if (strtolower($post->name) != strtolower($request->input('name')) && strtolower($post_name->name) == strtolower($request->input('name'))) {
                return redirect()->back()->with(["error" => "Post name is already existed!!"]);
            }
        }
        $post->update([
            "name" => $request->input('name'),
            "content" => $request->input('content'),
            "category_id" => $request->input('category_id'),
        ]);
        return redirect()->route('posts.index')->with(["status" => "Post updated."]);
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
        $post = Post::find($id);
        $post->delete();
        return response()->json([
            "status" => "Post deleted."
        ]);
    }
}
