@extends('layouts.app')

@section('main-page')
    <div class="mx-20 bg-white rounded-xl p-4">
        <h1 class="text-2xl font-bold text-center bg-slate-800 text-white p-1 rounded-xl">{{ $page_title }}</h1>
        <div class="flex flex-row mt-2 ">
            <div class="flex-1 md:border-r-2 md:border-r-slate-300 p-4">
                <img src="{{ asset('img/logo.jpg') }}" alt="">
            </div>
            <div class="flex-1 md:border-l-2 md:border-l-slate-300 p-4">
                <p class="">Hai, <span class="font-semibold">{{ Auth::user()->username }}</span> please fill your kiosk information detail!</p>
                <form action="{{ route('kiosk.store') }}" method="post" class="">
                    @csrf
                    <x-input-label value="Kiosk Name :" for="kiosk_name" />
                    <x-text-input id="kiosk_name" id="kiosk_name" class="w-1/2" />
                    <x-input-error :messages="$errors->first('kiosk_name')" />
                    <x-input-label value="Kiosk Description :" for="kiosk_description" class="mt-2"/>
                    <textarea name="kiosk_description" id="kiosk_description" cols="30" rows="3" class="border-slate-300 rounded-md"></textarea>
                    <x-input-error :messages="$errors->first('kiosk_description')" />
                    <x-input-label value="Kiosk Logo :" for="kiosk_logo" class="mt-2" />
                    <input class="w-1/2 bg-gray-200 border border-slate-300 rounded-md file:bg-slate-800 file:border-none file:text-white file:p-1" id="kiosk_logo" type="file" name="kiosk_logo">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="kiosk_logo_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
                    <x-input-error :messages="$errors->first('kiosk_logo')" />
                    <x-primary-button class="mt-4">submit</x-primary-button>
                </form>
            </div>
        </div>
    </div>
@endsection
