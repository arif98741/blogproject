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
use Exception;
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
            'posts' => Post::with(['user', 'tags', 'categories'])
                ->withTrashed()
                ->orderBy('id', 'desc')
                ->paginate(20),
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
            'slug' => 'required|min:3|unique:posts',
            'description' => 'required',
            'categories_id' => 'required',
            'status' => 'required',
            'meta_title' => 'sometimes|min:3|max:100',
            'meta_description' => 'sometimes|min:3|max:160',
            'meta_keywords' => 'sometimes|max:160',
        ];
        $data = $this->validate($request, $rules);
        $data['user_id'] = $this->getUserId();
        $data['created_by'] = $this->getUserId();


        if ($request->hasFile('feature_image')) {
            $uploadFile = ImageHelper::imageUpload($request, 'feature_image', 'post', 'post', true, 500, 450);

            $data['feature_image'] = $uploadFile['file_path'];
            $data['thumbnail_image'] = $uploadFile['thumb_path'];
        }

        unset($data['categories_id']);

        if ($post = Post::create($data)) {
            $this->syncCategoryTag($request, $post);

            AppFacade::generateActivityLog('posts', 'create', $post->id);
            return redirect()->route('admin.post.index')->with('alert', [
                'type' => 'success',
                'message' => 'Post Saved successfully',
            ]);
        }

        return redirect()->route('admin.post.index')->with('alert', [
            'type' => 'error',
            'message' => 'Post failed to insert',
        ]);
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
            'title' => 'Edit Post - ' . $post->title,
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
            'title' => 'required|min:3',
            'slug' => 'required|min:3',
            'description' => 'required',
            'categories_id' => 'required',
            'status' => 'required',
            'meta_title' => 'sometimes|min:3|max:100',
            'meta_description' => 'sometimes|min:3|max:160',
            'meta_keywords' => 'sometimes|max:160',
        ];


        $data = $this->validate($request, $rules);
        $data['updated_by'] = $this->getUserId();
        unset($data['categories_id']);

        if ($request->hasFile('feature_image')) {
            if (File::exists($post->feature_image)) {
                File::delete($post->feature_image);
            }
            if (File::exists($post->thumbnail_image)) {
                File::delete($post->thumbnail_image);
            }
            $uploadFile = ImageHelper::imageUpload($request, 'feature_image', 'post', 'post', true, 500, 450);
            $data['feature_image'] = $uploadFile['file_path'];
            $data['thumbnail_image'] = $uploadFile['thumb_path'];
        }

        if ($post->update($data)) {

            CategoryPost::where('post_id', $post->id)->delete();
            PostTag::where('post_id', $post->id)->delete();

            $this->syncCategoryTag($request, $post);
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

    /**
     * @param Request $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function destroy(Request $request, Post $post): RedirectResponse
    {
        $post->status = 'deleted';
        $post->save();
        $post->delete();

        AppFacade::generateActivityLog('posts', 'delete', $post->id);
        return redirect()->route('admin.post.index')->with('alert', [
            'type' => 'success',
            'message' => 'Post deleted successfully. But it is trash',
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function restore(Request $request, $id): RedirectResponse
    {
        try {
            Post::onlyTrashed()->where('id', $id)->restore();
            $post = Post::find($id);
            $post->status = 'published';
            $post->save();
            AppFacade::generateActivityLog('posts', 'restore', $post->id);
            return redirect()->route('admin.post.index')->with('alert', [
                'type' => 'success',
                'message' => 'Post successfully restored',
            ]);
        } catch (Exception $e) {
            return redirect()->route('admin.post.index')->with('alert', [
                'type' => 'error',
                'message' => 'Failed to restore post ' . $e->getMessage(),
            ]);
        }


    }

    /**
     * @param Request $request
     * @param Post $post
     * @return void
     */
    protected function syncCategoryTag(Request $request, Post $post): void
    {

        if ($request->has('categories_id')) {
            foreach ($request->categories_id as $category) {
                $blog_cats ['category_id'] = $category;
                $blog_cats['post_id'] = $post->id;
                CategoryPost::create($blog_cats);
            }
        }

        if ($request->has('tags')) {
            foreach ($request->tags as $tag) {
                $blog_tags ['tag_id'] = $tag;
                $blog_tags['post_id'] = $post->id;
                PostTag::create($blog_tags);
            }
        }
    }

}
