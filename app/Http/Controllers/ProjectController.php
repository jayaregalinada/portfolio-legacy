<?php

namespace Xkye\Http\Controllers;

use Illuminate\Http\Request;
use Xkye\Http\Controllers\Controller;
use Xkye\Http\Requests;
use Xkye\Image;
use Xkye\Project;
use Xkye\Services\Project\Factory as ProjectFactory;
use Xkye\Services\Project\ImageProcessor;

class ProjectController extends Controller
{

    /**
     * Setting middleware in constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $p = Project::with(['images'])->latest();
        if($p->get()->isEmpty()) {
            throw new \Exception('No Projects at the moment');
        }
        if($request->wantsJson() || $request->ajax()) {
            $data = $p->paginate()->toArray();

            return $this->responseSuccess('Successfully get page '. $data['current_page'], $data);
        }

        return view('project.all')->with(['projects' => $p->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, ProjectFactory $factory)
    {
        return $factory->execute($request->only('name', 'description'), route('project.index'))->with('success', 'Successfully new project created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        if($request->wantsJson() || $request->ajax() ) {
            return $this->responseSuccess('Successfully get product', Project::find($id));
        }

        return view('project.show')->with(['project' => Project::find($id)]);
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

        return view('project.edit')->with(['project' => Project::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $model = Project::find($id);
        $model->name = $request->get('name');
        $model->description = $request->get('description');
        if(!$model->save()) {
            throw new \Exception('Error in updating project');
        } else {
            return redirect(route('project.edit', $id))->with('success', 'Successfully updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $model = Project::find($id);
        if(!$model->delete()) {
            throw new \Exception('Error in deleting project');
        }

        return redirect(route('project.index'))->with('success', 'Successfully deleted');
    }

    public function createImage($id)
    {
        return view('project.image')->with(['project' => Project::find($id)]);
    }

    public function storeImage($id, Request $request, ProjectFactory $factory)
    {
        $directory = sha1( $request->file( 'file' )->getClientOriginalName() . date( "Y-n-d-His" ) ) . '/';
        $factory->createDirectory( $directory );
        $images = $factory->compileImage( $directory, $request->file( 'file' ), new ImageProcessor );
        $productInstance = Project::find( $id );
        $imageInstance = new Image([
            'sizes' => json_encode( $images ),
            'caption' => $productInstance->name
        ]);
        if(!$productInstance->images()->save( $imageInstance )) {
            throw new \Exception('Something went wrong on connecting your uploaded file to the Project. Please try again');
        } else {
            return redirect(route('project.edit.image', $id))->with('success', 'Successfully uploaded!');
        }
    }
}
