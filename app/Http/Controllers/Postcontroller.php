<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class Postcontroller extends Controller
{

    public function __construct(private PostService $postService)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->postService->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
       return $this->postService->store($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $this->postService->show($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->postService->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Post $post,PostRequest $request )
    {
        return $this->postService->update($post, $request->all());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post,$id)
    {
        return $this->postService->destroy($post,$id);
    }
}
