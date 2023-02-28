<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Request;

class Commentcontroller extends Controller
{

    public function __construct(private CommentService $commentService)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->commentService->index();
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
    public function store(CommentRequest $request)
    {
        return $this->commentService->store($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return $this->commentService->show($comment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Comment $comment, CommentRequest $request)
    {
        return $this->commentService->update($comment,$request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        return $this->commentService->destroy($comment);
    }
}
