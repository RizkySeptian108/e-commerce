@extends('layouts.app')

@section('main-page')

<div class="ms-10 me-10">
    <x-title>Address Setting</x-title>

    <div class="mt-5 p-8 bg-white shadow rounded-lg">
        <x-button-link href="{{ route('address.create') }}" >+ Add New Address</x-button-link>


    </div>
</div>


@endsection