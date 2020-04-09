@extends('layouts.app')

@section('content')
    <div class="container">
       @foreach($posts as $post)
            <div class="row">
                <div class="col-6 offset-3">
                    <a href="/p/{{$post->id}}">
                        <img src="/storage/{{ $post->image }}" alt="" class="w-100 h-100">

                    </a>
                </div>
            </div>
            <div class="row pt-2 pb-3">
                <div class="col-6 offset-3">
                    <div class="">
{{--                        <div class="d-flex align-items-center">--}}
{{--                            <div class="pr-4">--}}
{{--                                <img src="{{ $post->user->profile->profileImage() }}" alt="" class="rounded-circle w-100" style="max-width: 50px;">--}}
{{--                            </div>--}}
{{--                            <div class="">--}}
{{--                                <div class="font-weight-bold">--}}
{{--                                    <a href="/profile/{{ $post->user->id }}" >--}}
{{--                                        <span class="text-dark">{{ $post->user->username }}</span>--}}
{{--                                    </a>--}}
{{--                                    <a href="#" class="pl-3">Follow</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}
                        <p>
            <span class="font-weight-bold">
            <a href="/profile/{{ $post->user->id }}" >
              <span class="text-dark">{{ $post->user->username }}</span>
            </a></span> {{ $post->caption }}
                        </p>
                    </div>
                </div>
            </div>

        @endforeach
           <div class="row">
               <div class="col-12 d-flex justify-content-center">
                   {{ $posts->links()  }}
               </div>
           </div>
    </div>
@endsection
