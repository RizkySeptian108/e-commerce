@extends('layouts.app')

@section('main-page')
    <div class="ms-10 me-10">

        <x-title>Add New Address</x-title>

        <div class="mt-5 p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <form method="post" action="{{ route('address.update', $address->id) }}" class="flex flex-col gap-6">
                @csrf
                @method('PUT')
                <div>
                    <x-input-label for="recipient_name" :value="__('Recipient Name')" />
                    <x-text-input id="recipient_name" name="recipient_name" type="text" class="mt-1 block w-full" value="{{ old('recipient_name', $address->recipient_name) }}" />
                    <x-input-error :messages="$errors->get('recipient_name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="phone_number" :value="__('Phone Number ( use +62 format )')" />
                    <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" value="{{ old('phone_number', $address->phone_number) }}" />
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                </div>
        
                <div>
                    <x-input-label for="address_label" :value="__('Address Label')" />
                    <x-text-input id="address_label" name="address_label" type="text" class="mt-1 block w-full" value="{{ old('address_label', $address->address_label) }}"  />
                    <x-input-error :messages="$errors->get('address_label')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="address_benchmark" :value="__('Address Benchmark')" />
                    <x-text-input id="address_benchmark" name="address_benchmark" type="text" class="mt-1 block w-full" value="{{ old('address_benchmark', $address->address_benchmark) }}" />
                    <x-input-error :messages="$errors->get('address_benchmark')" class="mt-2" />
                </div>
        
                <div>
                    <x-input-label for="full_address" :value="__('Full Address')" />
                    <x-textarea-input name="full_address" class="mt-1 block w-full" :cols="30" :rows="5" oldValue="{{ old('full_address', $address->full_address) }}" />
                    <x-input-error :messages="$errors->get('full_address')" class="mt-2" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button >Submit</x-primary-button>
                </div>
                
            </form>
        </div>
    </div>
@endsection