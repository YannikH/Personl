<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Project;
use App\Template;
use App\Page;
use Auth;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [
            'projects'=>Project::where('user_id', Auth::user()->id)->get()
        ];
        return view('project.index', $data);
    }

    public function show($id)
    {
        $data = [
            'project'=>Project::where([
                ['user_id', Auth::user()->id],
                ['id', $id]
                ])->firstOrFail(),
            'templates'=>Template::pluck('name','path')
        ];
        return View('project.project', $data);
    }

    public function edit($id)
    {
        $data = [
            'project' => Project::where([
                ['user_id', Auth::user()->id],
                ['id', $id]
                ])->firstOrFail(),
            'pageSelect' => Page::where('project_id', $id)->pluck('name', 'id')
        ];
        return View('project.project-edit', $data);
    }

    public function create()
    {
        $project = Project::create(['name'=>'new project','url'=>'new', 'active'=>false,'user_id'=>Auth::user()->id]);
        return Redirect::route('projects.edit', ['id'=>$project->id]);
    }

    public function update(Request $request, $id)
    {
        $project = Project::where([
                ['user_id', Auth::user()->id],
                ['id', $id]
                ])->firstOrFail();
        if($request->get('active') == null) {
           $request->merge(['active'=>'0']);
        }

        if (!$project->update($request->all())) {
            return Redirect::back()
                    ->with('message', 'Something went wrong happened while saving your model')
                    ->withInput();
        }

        return Redirect::route('projects.show', ['id' => $id])
                    ->with('message', 'Project updated.');
    }
}
