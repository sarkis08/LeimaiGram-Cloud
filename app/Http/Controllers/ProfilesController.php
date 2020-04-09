<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use function foo\func;

class ProfilesController extends Controller
{
    public function index(User $user) // Model Route Binding
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        $postsCount = Cache::remember(
            'count.posts' . $user->id,
            now()->addSecond(30),
            function () use ($user) {
                 return $user->posts->count();
            });
        $followersCount = Cache::remember(
            'count.followers' . $user->id,
            now()->addSecond(30),
            function () use ($user) {
                return $user->profile->followers->count();

            });
        $followingCount = Cache::remember(
            'count.following' . $user->id,
            now()->addSecond(30),
            function () use ($user) {
                return $user->following->count();
            });

        //$user = User::findOrFail($user); // Alternative is use Route Model Binding eg. \App\User
        return view('profiles.index', compact('user', 'follows', 'postsCount', 'followersCount', 'followingCount'));
    }

    public function edit(User $user)
    {
      $this->authorize('update', $user->profile);

      return view('profiles.edit', compact('user'));
    }

    // updating user profile
    public function update(User $user)
    {
      $this->authorize('update', $user->profile);

      $data = request()->validate([
        'title' => 'required',
        'description' => 'required',
        'url' => 'url',
        'image' => '',
      ]);

      // dd($data);


      if (request('image')) {
        // Storing an profile image to a specific drive eg. public
        $imagePath = request('image')->store('profile', 'public');

        // Resizing or Fitting the image using Intervention lib
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
        $image->save();

        $imageArray = ['image' => $imagePath];
      }

      auth()->user()->profile()->update(array_merge(
        $data,
        $imageArray ?? [],
      ));

      return redirect("/profile/{$user->id}");
    }
}
