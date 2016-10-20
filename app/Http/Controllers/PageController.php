<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Page;
use App\Project;
use App\Template;
use Auth;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     //   $this->middleware('auth');
    }

    public function store(Request $request)
    {
        Page::create($request->all());
        return Redirect::route('projects.show', ['id' => $request->get('project_id')]);
    }

    public function show($url, $sub = null, $edit = '') {
        $project = null;
        if(Auth::user())
        {
            $project = Project::where([['url', $url],['active', 1]])
                ->orWhere([['url', $url],['user_id', Auth::user()->id]])
                ->firstOrFail();
        }else{
            $project = Project::where([['url', $url],['active', 1]])
                ->firstOrFail();
        }
        $page = $project->mainPage;
        if($sub == 'edit' || ($edit == 'edit')) {
            $edit = '-edit';
        }
        if($sub && $sub != 'edit' && $project) {
            $page = Page::where([['url', $sub],['project_id', $project->id]])->firstOrFail();
        }
        $page->rawContent = $page->content;
        $page->content = json_decode($page->content, true);
        $page->project = $project;
        return view('templates.' . $page->template . $edit, $page);
    }

    public function update(Request $request, $url, $sub = null) {
        $project = Project::where([['url', $url],['user_id', Auth::user()->id]])->firstOrFail();
        $page = $project->mainPage;
        if($sub && $sub != 'edit' && $project) {
            $page = Page::where([['url', $sub],['project_id', $project->id]])->firstOrFail();
        }

        $viewData = $request->get('parsed');
        $page->content = json_encode($viewData);
        $page->save();
        //var_dump($page->content);die;

        return Redirect::route('page.show', ['url' => $url, 'sub' => $sub]);
    }
}
