@extends('layouts.admin')
@section('content')
    {{-- @dd($messages) --}}
    <div class="container">
        <h3 class="text-center py-4 mt-3">Inbox ({{ count($messages) }})</h3>
        @foreach ($messages as $message)
            <div class="card p-4 mb-4">
                <div class="row d-flex justify-content-between">
                    <div class="w-50">
                        <h5 class="col-auto">Message from: {{ $message->name }}</h5>
                        <p class="col-auto sender-email"><span class="fw-bold">Email:</span> {{ $message->email }}</p>
                    </div>
                    <div class="d-flex justify-content-end w-50">{{ $message->createdAt }}</div>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $message->text }}</p>
                </div>
            </div>
        @endforeach
        {{ $messages->links() }}
    </div>
@endsection
