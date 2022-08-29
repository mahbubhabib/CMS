<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::all();

        return view('page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = Page::all();

        return view('page.create', compact('pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $this->validate($request, [
                'title'      =>  'required|max:191',
                'content'      =>  'required',
                'parent_id'      =>  'required',
            ]);

            Page::create($request->all());
            DB::commit();

            return redirect()->route('pages.index')->with([ 'alert-type' => 'success','message' => 'Category added successfully']);
        }catch(Exception $ex){
            DB::rollBack();
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $slugs = explode('/', $slug);
        $pages = Page::whereIn('slug', $slugs)->get()->keyBy('slug');

        $parent = null;

        foreach ($slugs as $slug) {
            $page = $pages->get($slug);

            if (! $page) {
                throw (new ModelNotFoundException())->setModel(Page::class);
            }

            if ($parent && $page->parent_id != $parent->getKey()) {
                abort(404);
            }
            $parent = $page;
        }

        return view('page.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
