<?php
namespace App\Services;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class PostService
{
    public function store($params)
    {
        $url = request()->url();
        if (strpos($url, 'api') === false) {
                $params['user_id'] = 1;
                Post::create($params);
                return response()->json([
                    'message' => 'Post created successfully',
                ], 202);
        } else {
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
    }

    public function index()
    {
        $url = request()->url();
        if (strpos($url, 'api') === false) {
            if (request()->ajax()) {
                $data = Post::latest()->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($row) {
                        return $row->created_at;
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editPost">Edit</a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';

                        /* $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Add</a>';
                        $btn = $btn.' <a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>'; */
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('post.index');
        } else {
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

    public function update($post, $params)
    {
        $url = request()->url();
        if (strpos($url, 'api') === false) {
                $post->update($params);
                return response()->json([
                    'message' => 'Post updated successfully',
                ], 202);
        }
        else {
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
    }

    public function destroy($post,$id)
    {
        $url = request()->url();
        if (strpos($url, 'api') === false) {
                Post::find($id)->delete();
                return response()->json([
                    'message' => 'Post deleted successfully',
                ], 200);
        }
        else {
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

    public function edit($id)
    {
        $post = Post::find($id);
        return response()->json($post);
    }
}
