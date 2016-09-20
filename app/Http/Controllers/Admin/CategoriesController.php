<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Word;
use App\Models\Answer;
use Auth;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\CreateCategoryRequest;
use DB;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderby('id')->paginate(config('paginate.category.normal'));

        return view('admin.category-manager', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $config = config('common.category.path');

        if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $fileName = uniqid() . '-' . $photo->getClientOriginalName();
                $request->file('photo')->move(base_path() . $config['public_photo_url'], $fileName);
        } else {
            $fileName = $config['default_name_photo'];
        }

        $data = $request->only('name', 'description');
        $data['photo'] = $fileName;

        if (Category::create($data)) {
            return redirect()->action('Admin\CategoriesController@index')
                             ->withSuccess(trans('admin/categories.category_create_success'));
        }

        return redirect()->action('Admin\CategoriesController@show')
                         ->withErrors(trans('admin/categories.category_create_errors'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if ($category) {
            return view('admin.category-detail', compact('category'));
        }

        return redirect()->action('Admin\CategoriesController@index')
                         ->withErrors(trans('admin/categories.error_message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);

        if ($category) {
            return view('admin.category-update', compact('category'));
        }

        return redirect()->action('Admin\CategoriesController@index')
                         ->withErrors(trans('admin/categories.error_message'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            if ($category) {
                return redirect()->action('Admin\CategoriesController@show', compact('category'))
                                 ->withSuccess(trans('admin/categories.category_update_success'));
            }

            return redirect()->action('Admin\CategoriesController@show', compact('category'))
                             ->withErrors(trans('admin/categories.category_update_errors'));
        }

        return redirect()->action('Admin\CategoriesController@index')
                         ->withErrors(trans('admin/categories.error_message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $category = Category::with('words')->find($id);
            $wordsId = $category->words()->pluck('id');
            Answer::whereIn('word_id', $wordsId)->delete();
            Word::whereIn('id', $wordsId)->delete();
            $category->delete();
            DB::commit();

            return redirect()->action('Admin\CategoriesController@index')
                                 ->withSuccess(trans('admin/categories.category_delete_success'));
        }
        catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(trans('admin/categories.category_delete_fail'));
        }
    }
}
