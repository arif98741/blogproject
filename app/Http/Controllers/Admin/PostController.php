<?php

namespace App\Http\Controllers\Admin;

use App\AppTrait\AuthTrait;
use App\Facades\AppFacade;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryPost;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    use AuthTrait;

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data = [
            'posts' => Post::with(['user'])->orderBy('id', 'desc')->paginate(20),
            'title' => 'Post List',
        ];
        return view('back.post.index')->with($data);
    }


    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $data = [
            'categories' => Category::categoryTree('category_name', 'asc'),
            'tags' => Tag::orderBy('tag_name')->get(),
            'post_statuses' => Config::get('app-config.post_status'),
            'title' => 'Add Post',
        ];

        return view('back.post.create')->with($data);
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:3|unique:posts',
            'description' => 'required',
            'categories_id' => 'required',
            'status' => 'required',
            'meta_title' => 'sometimes|min:3|max:100',
            'meta_description' => 'sometimes|min:3|max:160',
            'meta_keywords' => 'sometimes|max:160',
        ];
        $data = $this->validate($request, $rules);
        $data['user_id'] = $this->getUserId();


        if ($request->hasFile('feature_image')) {
            $uploadfile = ImageHelper::imageUpload($request, 'feature_image', 'post', 'post', true, 500, 450);

            $data['feature_image'] = $uploadfile['file_path'];
            $data['thumbnail_image'] = $uploadfile['thumb_path'];
        }

        if ($post = Post::create($data)) {
            foreach ($request->categories_id as $category) {
                $blog_cats ['category_id'] = $category;
                $blog_cats['post_id'] = $post->id;
                CategoryPost::create($blog_cats);
            }
            foreach ($request->tags as $tag) {
                $blog_tags ['tag_id'] = $tag;
                $blog_tags['post_id'] = $post->id;
                PostTag::create($blog_tags);
            }

            AppFacade::generateActivityLog('posts', 'create', $post->id);
            return redirect()->route('admin.post.index')->with('alert', [
                'type' => 'success',
                'message' => 'Post Saved successfully',
            ])->with($data);
        }

        return redirect()->route('admin.post.index')->with('alert', [
            'type' => 'error',
            'message' => 'Post failed to insert',
        ])->with($data);
    }

    /**
     * @param Post $post
     * @return Application|Factory|View
     */
    public function edit(Post $post)
    {
        $data = [
            'categories' => Category::categoryTree('category_name', 'asc'),
            'post_statuses' => Config::get('app-config.post_status'),
            'tags' => Tag::orderBy('tag_name')->get(),
            'post_tags' => PostTag::where('post_id', $post->id)->get()->pluck('tag_id')->toArray(),
            'post_categories' => CategoryPost::where('post_id', $post->id)->get()->pluck('category_id')->toArray(),
            'post' => $post,
            'title' => 'Edit Post - '.$post->title,
        ];

        return view('back.post.edit')->with($data);
    }

    /**
     * @return RedirectResponse
     * @throws ValidationException
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

        $data = $this->validate($request, $rules);
        $data['updated_by'] = $this->getUserId();

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
            foreach ($request->categories_id as $category) {
                $cats ['category_id'] = $category;
                $cats['post_id'] = $post->id;
                CategoryPost::create($cats);
            }
            AppFacade::generateActivityLog('posts', 'update', $post->id);

            return redirect()->route('admin.post.index')->with('alert', [
                'type' => 'success',
                'message' => 'Post updated successfully',
            ])->with($data);
        }

        return redirect()->route('admin.post.index')->with('alert', [
            'type' => 'error',
            'message' => 'Post failed to update',
        ])->with($data);
    }

}
