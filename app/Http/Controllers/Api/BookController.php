<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BookIssueRequest;
use App\Http\Requests\Api\BookReturnRequest;
use App\Http\Requests\BookRequest;
use App\Http\Resources\Api\BookResource;
use App\Http\Resources\Api\IssuceResource;
use App\Models\Book;
use App\Models\BookIssue;
use Carbon\Carbon;
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
        $book = Book::with('category')->find($request->id);
        $issued = BookIssue::where('frontend_use_id', auth()->user()->id)->where('book_id', $request->id)->first();

        if($issued) {
            return response()->json([
                'message' => 'You already issued this book'
            ], 500);
        }
        
        if($book->quantity == 0) {

            return response()->json([
                'message' => 'This is out of stock'
            ], 500);

        }

        if($book) {

            $book->update([
                'quantity' => $book->quantity-1
            ]);

            $issue = BookIssue::create([
                'book_id' => $request->id,
                'category_id' => $book->category->id,
                'frontend_use_id' => auth()->user()->id,
                'to_return_date' => Carbon::now()->addMonth()->toDateString(),
                'category' => $book->category->id,
            ]);

            return response()->json([
                'data' => [
                    'to_return_date' => Carbon::now()->addMonth()->toDateString()
                ],
                'message' => 'success'
            ], 200);
        }
    }

    public function return(BookReturnRequest $request) {

        $issue = BookIssue::with('book')->where('id', $request->issue_id)->where('status', 'issued')->first();

        if($issue) {

            $now = Carbon::now()->toDateString();
            $date1 = Carbon::parse($now);
            $date2 = Carbon::parse($issue->to_return_date);

            if ($date1->greaterThanOrEqualTo($date2)) {
                $overdueDays = $date1->diffInDays($date2); // Calculate overdue days
            } else {
                $overdueDays = 0; // Set overdue days to 0 if the due date is in the future
            }

            $issue->update([
                'returned_date' => $now,
                'status' => 'returned',
                'overdue_days' => $overdueDays
            ]);

            $issue->book()->update([
                'quantity' => $issue->book->quantity + 1
            ]);
    
            return response()->json([
                'message' => 'You have successfully returned the book'
            ], 200);
        } else {
    
            return response()->json([
                'message' => 'Issue not found'
            ], 500);
        }

    }

    public function issueHistory(Request $request)
    {
        $issue = BookIssue::with(['book', 'category'])->where('frontend_use_id', auth()->user()->id)->paginate($request->paginate_count);

        return IssuceResource::collection($issue);
    }
}
