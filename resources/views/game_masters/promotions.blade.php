@extends('layouts.admin')
@section('content')
    <div class="container my-4">
        <h2>
            Choose your tier
        </h2>

        <div class="d-flex gap-4 text-center">
            @foreach ($promotionTiers as $promotionTier)
                <div class="card" style="width: 18rem;">
                    <img src="/img/{{ $promotionTier['img'] }}" class="card-img-top" alt="{{ $promotionTier['tier'] }}">
                    <div class="card-body">
                        <div class="form-check">
                            <h5>{{ $promotionTier['message'] }}</h5>
                            <input class="form-check-input" type="radio" name="promotion_tier"
                                id="promotion_tier_{{ $promotionTier['tier'] }}">
                            <label class="form-check-label" for="promotion_tier_{{ $promotionTier['tier'] }}">
                                {{ $promotionTier['tier'] }}
                            </label>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('css/gm-promotions.css') }}" rel="stylesheet">
@endpush
