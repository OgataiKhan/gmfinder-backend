@extends('layouts.admin')
@section('content')
    <div class="container">
        <h3 class="text-center py-4 mt-3">Received Reviews ({{ count($reviews) }})</h3>
        @foreach ($reviews as $review)
            <div class="card p-4 mb-4 reviews">
                <div class="row d-flex justify-content-between">
                    <div class="w-50">
                        <h5 class="col-auto">Review by: {{ $review->name }}</h5>
                        <p class="col-auto sender-email">Email: {{ $review->email }}</p>
                    </div>
                    <div class="d-flex justify-content-end w-50">{{ $review->createdAt }}</div>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $review->text }}</p>
                </div>
            </div>
        @endforeach
        {{ $reviews->links() }}
    </div>
@endsection
