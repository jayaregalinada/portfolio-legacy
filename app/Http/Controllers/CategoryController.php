<?php

namespace Xkye\Http\Controllers;

use Xkye\Http\Requests;
use Xkye\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Xkye\Category;
use Xkye\Project;
use Xkye\Http\Requests\CategoryPostRequest;
use Illuminate\Contracts\Validation\ValidationException;

class CategoryController extends Controller
{

    /**
     * Setting middleware in constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'showProjects']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $p = ($request->get('trashed')) ? Category::withTrashed()->latest() : Category::latest();
        if($p->get()->isEmpty()) {
            throw new \Exception('No Categories at the moment');
        }
        if($request->wantsJson() || $request->ajax()) {
            $data = $p->get()->toArray();

            return $this->responseSuccess('Successfully get all categories', $data);
        }

        return view('category.all')->with(['categories' => $p->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CategoryPostRequest $request)
    {
        Category::create($request->all());

        return redirect(route('category.index'))->with('success', 'Successfully created new category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $model = Category::search($id);

        if($request->wantsJson() || $request->ajax() ) {
            return $this->responseSuccess('Successfully get product', $model);
        }

        return view('category.edit')->with(['category' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        if($request->wantsJson() || $request->ajax()) {
            throw new \Exception('Editing is not supported by AJAX');
        }

        return view('category.edit')->with(['category' => Category::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $model = Category::withTrashed()->find($id);
        if($request->has('restore')) {
            $model->restore();
        } else {
            $model->name = $request->get('name');
            $model->description = $request->get('description');
            $model->slug = $request->get('slug');
        }
        if(!$model->save()) {
            throw new \Exception('Error in updating category');
        }

        return redirect(route('category.edit', $id))->with('success', 'Successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $model = Category::withTrashed()->find($id);
        if($model->trashed()) {
            $model->forceDelete();
        } else {
            $model->delete();
        }

        return redirect(route('category.index'))->with('success', 'Successfully deleted category');
    }

    public function showProjects(Request $request, $id)
    {
        $model = (!is_numeric($id)) ? Category::findBySlug($id) : Category::find($id);

        if($model->projects()->get()->isEmpty()) {
            throw new \Exception('No Projects at the moment in this category.');
        }
        if($request->wantsJson() || $request->ajax()) {
            return $this->responseInJson(['success' => [
                'title' => 'Success!',
                'message' => 'Successfully get all projects',
                'category' => $model,
                'data' => $model->projects()->paginate()->toArray(),
            ]]);
        }

        return view('project.all')->with(['projects' => $model->projects, 'category' => $model]);
    }

    public function deleteProject(Request $request, $category, $projectId)
    {
        $model = Category::search($category);
        $model->projects()->detach($projectId);
        if($request->has('redirect')) {
            return redirect($request->get('redirect'))->with('success', 'Successfully deleted project to category');
        } else {
            return redirect(route('category.show.projects', $model->id))->with('success', 'Successfully deleted project to category');
        }
    }

    public function addProjects($id)
    {
        return view('category.projects')->with(['projects' => Project::all(), 'category' => Category::search($id)]);
    }

    public function storeProjects(Request $request, $id)
    {
        $model = Category::search($id);
        $model->projects()->sync([ $request->get('project') ], false);

        return redirect(route('category.store.projects', $model->id))->with('success', 'Successfully added project to category');
    }

}
