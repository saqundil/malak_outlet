@extends('layouts.main')

@section('content')

@include('partials.home.styles')

<main class="container mx-auto px-4" style="max-width: 1400px;">
    
    @include('partials.home.hero-section')

    @include('partials.home.promotional-cards')

    @include('partials.home.toy-categories')

    @include('partials.home.featured-products')

    @include('partials.home.new-arrivals')

    @include('partials.home.advertisement-banner')

    @include('partials.home.best-sellers')

    @include('partials.home.sale-products')

    @include('partials.home.newsletter')

    @include('partials.home.brand-features')

</main>

@endsection
