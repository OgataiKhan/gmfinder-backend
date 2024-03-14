@extends('layouts.admin')
@section('content')


<div class="container">
    <div class="thank-you-container">
        <i class="fas fa-check-circle thank-you-icon"></i>
        <h1 class="thank-you-heading">Thank You!</h1>
        <p class="thank-you-message">Your payment has been successfully processed.</p>
    </div>
</div>




@endsection

@push('styles')
<link href="{{ asset('css/gm-success.css') }}" rel="stylesheet">
@endpush