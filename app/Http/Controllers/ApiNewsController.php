<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use App\Models\ApiNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'author_name' => 'required',
            'title' => 'required',
            'news' => 'required',
            'image' => 'required',
            'status' => 'required',
            'category_id' => 'required',
        ]);
        $news = new News();
        $news->author_name=$request->author_name;
        $news->title=$request->title;
        $news->news=$request->news;
        $news->image=$request->image;
        $news->category_id =$request->category_id;
        $news->status='active';
        $news->user_id = Auth::user()->id;
        $news->save();
        return $news;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApiNews  $apiNews
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return News::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApiNews  $apiNews
     * @return \Illuminate\Http\Response
     */
    public function edit(ApiNews $apiNews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApiNews  $apiNews
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $news = News::find($id);
        $news->update($request->all());
        return $news;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApiNews  $apiNews
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return News::destroy($id);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApiNews  $apiNews
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return News::Where('name', 'like', '%' . $name . '%')->get();
    }
}
