@extends('layouts.admin')
@section('content')
    <div class="container py-5">
        @foreach ($reviews as $review)
            <div class="card p-4 mb-4">
                <div class="row justify-content-between">
                    <h5 class="col-auto">Review from: {{ $review->name }}</h5>
                    <h5 class="col-auto">{{ $review->email }}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $review->text }}</p>
                </div>
            </div>
        @endforeach
        {{ $reviews->links() }}
    </div>
@endsection
