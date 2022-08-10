<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Validator;


class CategoryController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        //return Category::categoryTree();

        $data = [
            //'categories' => Category::orderBy('category_name')->get()
            'categories' => Category::categoryTree()
        ];
        return view('back.category.index')->with($data);
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $data = [];
        return view('back.category.create')->with($data);
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return Application|Factory|View
     */
    public function edit(Request $request, Category $category)
    {
        $data = [
            'category' => $category
        ];
        return view('back.category.edit')->with($data);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'category_name' => 'required|min:3|max:100|unique:categories',
        ];


        $validator = Validator::make($data = $request->all(), $rules);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 400); // 400 being the HTTP code for an invalid request.
        }

        if (Category::create($data)) {

            return Response::json(array('success' => 'Category Inserted successfully'), 200);
        }

        return Response::json(array(
            'success' => false,
            'errors' => [
                'error' => [
                    'Failed to insert category'
                ]
            ]
        ), 400);


    }

    /**
     * @return void
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'category_name' => 'required|min:3|max:100|unique:categories,category_name,' . $category->id
        ];


        $validator = Validator::make($data = $request->all(), $rules);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 400); // 400 being the HTTP code for an invalid request.
        }

        if ($category->update($data)) {

            return Response::json(array('success' => 'Category updated successfully'), 200);
        }

        return Response::json(array(
            'success' => false,
            'errors' => [
                'error' => [
                    'Failed to insert category'
                ]
            ]
        ), 400);

    }

    /**
     * @return void
     */
    public function destroy()
    {

    }
}
