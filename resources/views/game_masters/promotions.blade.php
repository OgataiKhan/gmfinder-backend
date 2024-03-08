@extends('layouts.admin')
@section('content')
    <div class="container my-4">
        <h2>
            Choose your tier
        </h2>

        <div class="text-center">
            <form action="{{ route('promotions.store') }}" method="POST">
                @csrf
                <div class="d-flex gap-4">
                    @foreach ($promotionTiers as $promotionTier)
                        <div class="card" style="width: 18rem;">
                            <img src="/img/{{ $promotionTier['img'] }}" class="card-img-top"
                                alt="{{ $promotionTier['tier'] }}">
                            <div class="card-body">
                                <div class="form-check">
                                    <h5>{{ $promotionTier['message'] }}</h5>
                                    <input class="form-check-input" type="radio" name="tier" value="{{ $promotionTier['tier'] }}"
                                        id="promotion_tier_{{ $promotionTier['tier'] }}" @checked($promotionTier['tier'] === 'silver')>
                                    <label class="form-check-label" for="promotion_tier_{{ $promotionTier['tier'] }}">
                                        {{ $promotionTier['tier'] }}
                                    </label>
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
                <div class="d-flex mt-3">
                    <button id="create-button" type="submit" class="btn btn-void-orange">Purchase</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('css/gm-promotions.css') }}" rel="stylesheet">
@endpush
