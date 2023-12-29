@extends('layouts.app')

@section('main-page')
    <x-title class="mb-4">
        {{ $page_title }}
    </x-title>
    <div class="bg-white rounded-md p-4">
        @if (session('success'))
            <x-alert color="green">{{ session('success') }}</x-alert>
        @endif
        <x-button-link href="{{ route('product.create') }}" class="bg-slate-800">add product</x-button-link>
    </div>
@endsection