@extends('layouts.admin')
@section('content')
    <div class="container py-5">
        @foreach ($messages as $message)
            <div class="card p-4 mb-4">
                <div class="row justify-content-between">
                    <h5 class="col-auto">Message from: {{ $message->name }}</h5>
                    <h5 class="col-auto">{{ $message->email }}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $message->text }}</p>
                </div>
            </div>
        @endforeach
        {{ $messages->links() }}
    </div>
@endsection
