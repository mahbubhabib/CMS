<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use DB;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

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
            $rules = array(
                'title'             =>  'required|max:191',
                'content'           =>  'required',
                'parent_id'         =>  'required',
            );

            $validator = Validator::make ( $request->all(), $rules);

            if ($validator->fails())
                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            else {
                $page = Page::create($request->all());

                DB::commit();
                return response()->json(['success' => $page, "error" => "", 'message' => 'Page has been added successfully!']);
            }
        }catch(Exception $e){
            DB::rollBack();
            return response()->json($e);
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
        $pages = Page::all();
        $page = Page::findOrFail($id);

        return view('page.edit',compact('pages','page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try{
            $rules = array(
                'title'             =>  'required|max:191',
                'content'           =>  'required',
                'parent_id'         =>  'required',
            );

            $validator = Validator::make ( $request->all(), $rules);

            if ($validator->fails())
                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            else {
                $page = Page::findOrFail($request->id)->update($request->all());

                DB::commit();
                return response()->json(['success' => $page, "error" => "", 'message' => 'Page has been updated successfully!']);
            }

        }catch(Exception $e){
            DB::rollBack();
           return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Page::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Page has been deleted successfully!');
    }
}
