<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function  index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id', $users)->with('user')->orderBy('created_at', 'DESC')->paginate(5);  // alternative of created_at is latest()

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
      return view('posts.create');
    }

    public function store()
    {
      $data = request()->validate([
        //'another'=> '', // Ignored if there is other validation
        'caption'=> 'required',
        'image'=> ['required', 'image'],
      ]);

      // Storing an image to a specific drive eg. public
      $imagePath = request('image')->store('uploads', 'public');

      // Resizing or Fitting the image using Intervention lib
      $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
      $image->save();

      // Relationship when user is creating a posts
      auth()->user()->posts()->create([
        'caption' => $data['caption'],
        'image' => $imagePath,
      ]);

      return redirect('/profile/' . auth()->user()->id);
    }

    public function show(\App\Post $post) // Route Model Binding
    {
      return view('posts.show', compact('post'));
    }
}
