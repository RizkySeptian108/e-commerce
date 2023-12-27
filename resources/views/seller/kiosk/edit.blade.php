@extends('layouts.app')

@section('main-page')
<div class="max-w-7xl mx-auto p-4 rounded-md space-y-6 bg-white">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Kiosk Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your kiosk profile.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('kiosk.update', $kiosk) }}" class="mt-6 space-y-6 w-1/2" enctype="multipart/form-data" x-data="{image: null}">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="kiosk_name" :value="__('Kiosk Name')" />
            <x-text-input id="kiosk_name" name="kiosk_name" type="text" class="mt-1 block w-full" :value="old('kiosk_name', $kiosk->kiosk_name)" required autofocus autocomplete="kiosk_name" />
            <x-input-error class="mt-2" :messages="$errors->get('kiosk_name')" />
        </div>
        <div>
            <x-input-label for="kiosk_description" :value="__('Kiosk Description')" />
            <textarea name="kiosk_description" id="kiosk_description" cols="30" rows="2" class="mt-1 block w-full border border-slate-300 rounded-md">{{ old('kiosk_description', $kiosk->kiosk_description) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('kiosk_description')" />
        </div>

        <div class="flex flex-row items-center gap-11">
            <input type="hidden" value="{{ $kiosk->kiosk_logo }}" name="old_kiosk_logo">
            <img src="{{ asset('storage/' . $kiosk->kiosk_logo) }}" alt="{{ $kiosk->kiosk_name }}" class="w-1/4 border-4 border-slate-400 rounded-md overflow-hidden">
            <div x-show="image">
                <i class="fa-solid fa-arrow-right"></i>
                <span>change to</span>
            </div>
            <img :src="image" alt="{{ $kiosk->kiosk_name }}" class="w-1/4 border-4 border-slate-400 rounded-md overflow-hidden" x-show="image">
        </div>

        <div>
            <x-input-label for="kiosk_logo" :value="__('Kiosk Logo')" />
            <input class="w-1/2 bg-gray-200 border border-slate-300 rounded-md file:bg-slate-800 file:border-none file:text-white file:p-1" id="kiosk_logo" type="file" name="kiosk_logo" @change="image = URL.createObjectURL($event.target.files[0])">
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="kiosk_logo_help">SVG, PNG, JPG or GIF (MAX 2mb).</p>
            <x-input-error class="mt-2" :messages="$errors->get('kiosk_logo')" />
        </div>
        

        <div class="flex items-center gap-4">
            <x-primary-button type="submit">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'kiosk-profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</div>
@endsection