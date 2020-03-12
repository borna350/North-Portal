<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PostController extends Controller
{

    public function __construct ()
    {
        $this->middleware(['auth', 'clearance'])->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index ()
    {
        $posts = Post::orderby('id', 'desc')->paginate(5); //show only 5 items at a time in descending order
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create ()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store (Request $request)
    {

        //Validating title and body field
        $this->validate($request, [
            'title' => 'required|max:100',
            'body' => 'required',
        ]);
        $title = $request['title'];
        $body = $request['body'];
        $post = Post::create($request->only('title', 'body'));
        //Display a successful message upon save
        return redirect()->route('posts.index')->with('alert-info', 'Article,
             ' . $post->title . ' created');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Factory|View
     */
    public function show ($id)
    {
        $post = Post::findOrFail($id); //Find post of id = $id
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Factory|View
     */
    public function edit ($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update (Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:100',
            'body' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();
        return redirect()->route('posts.show', $post->id)->with('alert-info', 'Article, ' . $post->title . ' updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy ($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index')->with('alert-info', 'Article successfully deleted');
    }
}
