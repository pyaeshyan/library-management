<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BookIssueRequest;
use App\Http\Requests\BookRequest;
use App\Http\Resources\Api\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with('category')->where(function ($query) use ($request)
        {
            $request->has('title')
                && $query->where('title', 'like', '%' . $request->title . '%');

            $request->has('author')
                && $query->where('author', 'like', '%' . $request->author . '%');

            $request->has('category_id')
                && $query->where('category_id',$request->category_id);
        });

        return BookResource::collection($books->paginate($request->paginate_count));
    }

    public function issue(BookIssueRequest $request)
    {
        $book = Book::with('category')->where('quantity', '>', 0)->first();

        return response()->json([
            'data' => new BookResource($book)
        ], 200);
    }
}
