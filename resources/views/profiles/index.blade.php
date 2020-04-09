@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img src="{{ $user->profile->profileImage() }}" alt="" srcset="" class="rounded-circle w-100">
        </div>
        <div class="col-9 pt-5 pl-5">
            <div class="d-flex justify-content-between align-items-baseline">
              <div class="d-flex align-items-center pb-3">
                <div class="h4">{{ $user->username }}</div>

                <follow-button-component user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button-component>
              </div>

              @can('update', $user->profile)
                <a href="/p/create" class="btn btn-primary">Add New Post</a>
              @endcan
            </div>

            @can('update', $user->profile)
              <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
            @endcan
            <div class="d-flex">
                <div class="pr-3"><strong>{{ $postsCount }}</strong> posts</div>
                <div class="pr-3"><strong>{{ $followersCount }}</strong> followers</div>
                <div class="pr-3"><strong>{{ $followingCount }}</strong> following</div>
            </div>
            <div class="pt-4">
                <div><strong>{{ $user->profile->title }}</strong></div>
                <p>{{ $user->profile->description }}</p>
                <div><a target="_blank" href="{{ $user->profile->url }}">{{ $user->profile->url }}</a></div>
            </div>
        </div>


        <div class="row pt-4">
          @foreach($user->posts as $post)
            <div class="col-4 pb-4">
              <a href="/p/{{$post->id}}">
                <img src="/storage/{{ $post->image }}" alt="" srcset="" class="w-100 h-100">
              </a>
            </div>
          @endforeach
       </div>
    </div>

</div>
@endsection
