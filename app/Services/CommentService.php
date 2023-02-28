<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentService
{
  public function store($params) : JsonResponse
  {
    try {
      $params['user_id'] = 1;
      Comment::create($params);
      return response()->json([
        'message' => 'Comment created successfully',
      ], 201);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => $th->getMessage(),
      ], 400);
    }
  }

  public function index() : JsonResponse
  {
    try {
      $comments = Comment::with(['user','post'])->get();
      return response()->json([
        'message' => 'Comments fetched successfully',
        'data' => $comments,
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => $th->getMessage(),
      ], 400);
    }
  }

  public function show($comment) : JsonResponse
  {
    try {
      $comment = Comment::with(['user:id,name'])->where('id',$comment->id)->first();
      return response()->json([
        'message' => 'Comment fetched successfully',
        'data' => $comment,
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => $th->getMessage(),
      ], 400);
    }
  }

  public function update($comment, $params) : JsonResponse
  {
    try {
      $comment->update($params);
      return response()->json([
        'message' => 'Comment updated successfully',
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => $th->getMessage(),
      ], 400);
    }
  }

  public function destroy($comment) : JsonResponse
  {
    try {
      $comment->delete();
      return response()->json([
        'message' => 'Comment deleted successfully',
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => $th->getMessage(),
      ], 400);
    }
  }

}
