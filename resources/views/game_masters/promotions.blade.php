@extends('layouts.admin')
@section('content')
<div class="container my-4">
    @if ($user && $user->gameMaster && $user->gameMaster->is_active)
    <h2 class="text-center mb-4">
        Choose your tier
    </h2>

    <div class="text-center">
        <form action="{{ route('promotions.store') }}" method="POST">
            @csrf
            <div class="d-flex gap-4 justify-content-center">
                @foreach ($promotionTiers as $promotionTier)
                <div class="card" style="width: 18rem;">
                    <img src="/img/{{ $promotionTier['img'] }}" class="card-img-top" alt="{{ $promotionTier['tier'] }}">
                    <div class="card-body">
                        <div class="form-check">

                            <input class="form-check-input" type="radio" name="tier"
                                value="{{ $promotionTier['tier'] }}" id="promotion_tier_{{ $promotionTier['tier'] }}"
                                @checked($promotionTier['tier']==='silver' )>
                            <label class="form-check-label tier-label"
                                for="promotion_tier_{{ $promotionTier['tier'] }}">
                                {{ $promotionTier['tier'] }}
                            </label>
                            <p class="tier-msg">{{ $promotionTier['message'] }}</p>
                            <p class="tier-price">{{ $promotionTier['price'] }} €</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <input type="hidden" name="game_master_id" value="{{ $gameMasterId }}">
            @if ($errors->any())
            <div class="invalid-feedback">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="d-flex mt-4 justify-content-center">
                <button id="create-button" type="submit" class="btn btn-void-orange">Go to checkout</button>
            </div>
        </form>
    </div>
    @else
    <div class="alert p-3 d-flex flex-column align-items-center border border-2">
        <p>Create a Game Master profile to begin your adventure!</p>
        <a href="{{ route('game_master.create') }}" class="btn btn-void-orange">Create Profile</a>
    </div>
    @endif
</div>






</div>
@if (session('success_message'))
<div class="alert alert-success">
    {{ session('success_message') }}
</div>
@endif

@if (session('error_message'))
<div class="alert alert-danger">
    {{ session('error_message') }}
</div>
@endif
</div>
@endsection

@push('styles')
<link href="{{ asset('css/gm-promotions.css') }}" rel="stylesheet">
@endpush