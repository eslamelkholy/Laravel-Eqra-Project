<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use App\Http\Resources\Book as BookResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BookRequest;
use App\User;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
	public function index()
	{
		$books = Book::orderBy('created_at', 'desc')->paginate(10);
		// $books = Book::all()->orderBy('created_at', 'desc');
		// $books = Book::where('user_id', $_GET["user_id"])->orderBy('created_at', 'desc')->get();
		return BookResource::collection($books);
	}

	public function store(BookRequest $request)
	{
		$request['user_id'] = Auth::id();
		$newBook = new Book;
		$newBook->title = $request->title;
		$newBook->description = $request->description;
		$newBook->price = $request->price;
		$path = $request->file('coverImage')->store('public');
		$newBook->coverImagePath = Storage::url($path);
		$newBook->user_id = Auth::user()->id;
		$newBook->save();
		return
			response()->json(['newBook' => new BookResource($newBook), 'message' => "user updated successfully"], 200);
		// return $request;
	}

	public function show($id)
	{
		$book = $this->getBookById($id);
		if (is_null($book))
			return response()->json(["message" => "Book Not Found"], 404);
		return new BookResource($book);
	}

	public function update(Request $request, $id)
	{
		$book = $this->getBookById($id);
		if (is_null($book))
			return response()->json(["message" => "book Not Found"], 404);
		$book->update([
			'content' => $request->content
		]);
		return response()->json($book, 200);
	}

	public function destroy($id)
	{
		$book = $this->getBookById($id);
		if (is_null($book))
			return response()->json(["message" => "book Not Found"], 404);
		$book->delete();
		return response()->json(["message" => "book Deleted Successfully"], 200);
	}

	public function userBooks($id)
	{
		$user = User::find($id);
		$posts = Book::where("user_id", "=", $user->id)->get();

		return response()->json(["userBooks" => $posts], 200);
	}

	private function getBookById($id)
	{
		return Book::find($id);
	}
}
