<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data = [
            'posts' => Post::orderBy('id', 'desc')->get()
        ];
        return view('back.post.index')->with($data);
    }


    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $data = [
            'categories' => Category::orderBy('category_name', 'asc')->get(),
            'post_statuses' => Config::get('app-config.post_status'),
        ];

        return view('back.post.create')->with($data);
    }


    /**
     * @param Request $request
     * @return JsonResponse|void
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:3|unique:posts',
            'description' => 'required',
            'status' => 'required',
            'meta_title' => 'sometimes|min:3|max:100',
            'meta_description' => 'sometimes|min:3|max:160',
            'meta_keywords' => 'sometimes|max:160',
        ];

        $validator = Validator::make($data = $request->all(), $rules);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 400); // 400 being the HTTP code for an invalid request.
        }

        if ($request->hasFile('feature_image')) {
            $uploadfile = ImageHelper::imageUpload($request, 'feature_image', 'post', 'post', true, 500, 450);

            $data['feature_image'] = $uploadfile['file_path'];
            $data['thumbnail_image'] = $uploadfile['thumb_path'];
        }

        if (Post::create($data)) {

            return Response::json(array('success' => 'Post Inserted successfully'), 200);
        }

        return Response::json(array(
            'success' => false,
            'errors' => [
                'error' => [
                    'Failed to insert save post'
                ]
            ]
        ), 400);
    }

    /**
     * @param Post $post
     * @return Application|Factory|View
     */
    public function edit(Post $post)
    {
        $data = [
            'categories' => Category::orderBy('category_name', 'asc')->get(),
            'post_statuses' => Config::get('app-config.post_status'),
            'post' => $post
        ];

        return view('back.post.edit')->with($data);
    }

    /**
     * @return JsonResponse
     */
    public function update(Request $request, Post $post)
    {
        $rules = [
            'title' => 'required|min:3|unique:posts,title,' . $post->id,
            'description' => 'required',
            'status' => 'required',
            'meta_title' => 'sometimes|min:3|max:100',
            'meta_description' => 'sometimes|min:3|max:160',
            'meta_keywords' => 'sometimes|max:160',
        ];

        $validator = Validator::make($data = $request->all(), $rules);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 400); // 400 being the HTTP code for an invalid request.
        }

        if ($request->hasFile('feature_image')) {
            if (File::exists($post->feature_image)) {
                File::delete($post->feature_image);
            }
            if (File::exists($post->thumbnail_image)) {
                File::delete($post->thumbnail_image);
            }

            $uploadfile = ImageHelper::imageUpload($request, 'feature_image', 'post', 'post', true, 500, 450);

            $data['feature_image'] = $uploadfile['file_path'];
            $data['thumbnail_image'] = $uploadfile['thumb_path'];
        }

        if ($post->update($data)) {

            return Response::json(array('success' => 'Post updated successfully'), 200);
        }

        return Response::json(array(
            'success' => false,
            'errors' => [
                'error' => [
                    'Failed to update post'
                ]
            ]
        ), 400);
    }

}
