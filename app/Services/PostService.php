<?php
namespace App\Services;

use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostService
{
    public function store($params) : JsonResponse
    {
        try {
            $params['user_id'] = 1;
            Post::create($params);
            return response()->json([
                'message' => 'Post created successfully',
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
            $posts = Post::with(['comments','user'])->get();
            return response()->json([
                'message' => 'Posts fetched successfully',
                'data' => $posts,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 400);
        }
    }

    public function show($post) : JsonResponse
    {
        try {
            $post = Post::with(['user:id,name'])->where('id',$post->id)->first();
            return response()->json([
                'message' => 'Post fetched successfully',
                'data' => $post,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 400);
        }
    }

    public function update($post, $params) : JsonResponse
    {
        try {
            $post->update($params);
            return response()->json([
                'message' => 'Post updated successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 400);
        }
    }

    public function destroy($post) : JsonResponse
    {
        try {
            $post->delete();
            return response()->json([
                'message' => 'Post deleted successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 400);
        }
    }
}
