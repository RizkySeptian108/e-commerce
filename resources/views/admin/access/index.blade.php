@extends('layouts.app')

@section('main-page')
    <x-title>
        {{ $page_title }}
    </x-title>

    <div class="mt-4 w-full bg-white rounded-md p-3 inline-block">
        @if (session('success'))
            <x-alert color="green">
                {{ session('success') }}
            </x-alert>
        @endif
        <div></div>
        <div class="w-fit">
            <x-dropdown align="left" width="fit">
                <x-slot name="trigger">
                    <x-primary-button class="bg-gray-700 text-white hover:bg-gray-600" type="button">
                        Add Access Type
                    </x-primary-button>
                </x-slot>
                <x-slot name="content">
                    <form action="access" method="POST" class="p-3">
                        @csrf
                        <x-input-label for="access_type" >
                            <input type="text" name="access_type" id="access_type" placeholder="insert access type" class="rounded-md border-slate-500">
                        </x-input-label>
                        <x-primary-button type="submit" class="mt-2">
                            submit
                        </x-primary-button>
                    </form>
                </x-slot>
            </x-dropdown>
            @error('access_type')  
                <x-input-error :messages="$message" class="mt-2 "></x-input-error>
            @enderror
        </div>

        <div class="mt-4">
            <table class="border border-slate-500" >
                <thead>
                    <tr class="bg-slate-400 text-white font-semibold">
                        <th class="border border-slate-500 px-2 py-1 text-center">no</th>
                        <th class="border border-slate-500 px-28 py-1">access type</th>
                        <th class="border border-slate-500 px-2 py-1">action</th>
                    </tr>
                </thead>
                <tbody x-data="{update: null}">
                    @foreach ($access as $a)
                        <tr>
                            <td class="border border-slate-500 px-2 py-1 text-center">{{ $loop->iteration }}</td>
                            <td class="border border-slate-500 px-2 py-1">
                                <span :class="update === {{ $a->id }} ? 'hidden' : ''" >
                                    {{ $a->access_type }}
                                </span>
                                <form action="{{ route('access.update', $a) }}" :class="update === {{ $a->id }} ? 'block' : 'hidden'" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="access_type" value="{{ $a->access_type }}" class="p-1 rounded-md border-slate-400 focus:ring-blue-200">
                                    <x-primary-button type="submit">submit</x-primary-button>
                                </form>
                            </td>
                            <td class="border border-slate-500 px-2 py-1 text-center">
                                <i class="fa-solid fa-pen-to-square mr-2 cursor-pointer text-yellow-500" @click="update === {{ $a->id }} ? update = null : update = {{ $a->id }}"></i>
                                <form action="{{ route('access.destroy', $a) }}" method="POST" class="inline">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" onclick="return confirm('are you sure?')">
                                        <i class="fa-solid fa-trash cursor-pointer text-red-500"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <h2 class="text-2xl font-semibold">Account Access</h2>
            @error('access_id')  
                <x-input-error :messages="$message" class="mt-2 "></x-input-error>
            @enderror
            <table class="mt-2 border border-slate-500">
                <thead>
                    <tr class="bg-slate-400">
                        <th class="border border-slate-500 px-2 py-1">no</th>
                        <th class="border border-slate-500 px-2 py-1">name</th>
                        <th class="border border-slate-500 px-2 py-1">username</th>
                        <th class="border border-slate-500 px-2 py-1">email</th>
                        <th class="border border-slate-500 px-2 py-1">access type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accounts as $account)  
                        <tr class="">
                            <td class="border border-slate-500 px-2 py-1">{{ $loop->iteration }}</td>
                            <td class="border border-slate-500 px-2 py-1">{{ $account->name }}</td>
                            <td class="border border-slate-500 px-2 py-1">{{ $account->username }}</td>
                            <td class="border border-slate-500 px-2 py-1">{{ $account->email }}</td>
                            <td class="border border-slate-500 px-2 py-1">
                                <form action="{{ route('account-access', $account->id ) }}" method="POST">
                                    @csrf
                                    <select name="access_id" id="access_id" class="rounded-sm">
                                        @foreach ($access as $a)
                                            <option value="{{ $a->id }}" 
                                                @if ($account->access_id === $a->id)
                                                    selected
                                                @endif class="rounded-b-md ">
                                                {{ $a->access_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-primary-button type="submit">submit</x-button-primary>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection