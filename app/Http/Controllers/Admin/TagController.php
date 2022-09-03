<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data = [
            'tags' => Tag::with(['posts'])->orderBy('tag_name')->get()
        ];

        return view('back.tag.index')->with($data);
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $data = [];
        return view('back.tag.create')->with($data);
    }

    /**
     * @param Request $request
     * @param Tag $tag
     * @return Application|Factory|View
     */
    public function edit(Request $request, Tag $tag)
    {
        $data = [
            'tag' => $tag
        ];
        return view('back.tag.edit')->with($data);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'tag_name' => 'required|min:3|max:100|unique:tags',
        ];


        $validator = Validator::make($data = $request->all(), $rules);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 400); // 400 being the HTTP code for an invalid request.
        }

        if (Tag::create($data)) {

            return Response::json(array('success' => 'Tag Inserted successfully'), 200);
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
    public function update(Request $request, Tag $tag)
    {
        $rules = [
            'tag_name' => 'required|min:3|max:100|unique:tags,tag_name,' . $tag->id
        ];

        $validator = Validator::make($data = $request->all(), $rules);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 400); // 400 being the HTTP code for an invalid request.
        }

        if ($tag->update($data)) {

            return Response::json(array('success' => 'Tag updated successfully'), 200);
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
