@extends('layouts.main')
@section('content')
    <div class="p-4 sm:ml-64 mt-16">
        <div id="trackingApp"></div>
    </div>
@endsection

@push('js')
    @vite('resources/js/vue/tracking.js')
@endpush
