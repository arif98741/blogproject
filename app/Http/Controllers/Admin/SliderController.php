<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\SliderType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class SliderController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data = [
            //'categories' => Category::orderBy('category_name')->get()
            //     'categories' => Category::categoryTree()
            'sliders' => Slider::orderBy('id', 'asc')->get(),
        ];


        return view('back.slider.index')->with($data);
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $data = [
            'slider_types' => SliderType::orderBy('type_name')->get(),
        ];
        return view('back.slider.create')->with($data);
    }

    /**
     * @param Request $request
     * @param Slider $slider
     * @return Application|Factory|View
     */
    public function edit(Request $request, Slider $slider)
    {
        $data = [
            'slider' => $slider,
            'slider_types' => SliderType::orderBy('type_name')->get(),
        ];
        return view('back.slider.edit')->with($data);
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:3',
            'slider_type_id' => 'required|numeric',
            'image' => 'required',
            'status' => 'required',
        ];


        $data = $this->validate($request, $rules);
        $url = parse_url($data['image']);
        $data['image'] = ltrim($url['path'], '/');
        $data['created_by'] = $this->getUserId();


        if (Slider::create($data)) {
            return redirect()->route('admin.slider.index')->with([
                'message' => 'Slider added successfully !',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.slider.create')->with(
            [
                'message' => 'Failed to add slider',
                'alert-type' => 'error'
            ]
        );

    }

    /**
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Slider $slider)
    {
        $rules = [
            'title' => 'required|min:3',
            'slider_type_id' => 'required|numeric',
            'image' => 'required',
            'status' => 'required',
        ];


        $data = $this->validate($request, $rules);
        $url = parse_url($data['image']);
        $data['image'] = ltrim($url['path'], '/');
        $data['updated_by'] = $this->getUserId();

        if ($slider->update($data)) {
            return redirect()->route('admin.slider.index')->with([
                'message' => 'Slider updated successfully !',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.slider.create')->with(
            [
                'message' => 'Failed to update slider',
                'alert-type' => 'error'
            ]
        );


    }

    /**
     * @return RedirectResponse
     */
    public function destroy(Request $request, Slider $slider)
    {
        if ($slider->delete()) {
            return redirect()->route('admin.slider.index')->with([
                'message' => 'Slider deleted successfully !',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.slider.create')->with(
            [
                'message' => 'Failed to delete slider',
                'alert-type' => 'error'
            ]
        );
    }
}
