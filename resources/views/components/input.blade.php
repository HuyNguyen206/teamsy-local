@props([
    'name',
    'type' => 'text',
    'label' => 'name',
    'required' => true,
    'class' => null,
    'ruleHtml' => null
    ])
@php
    $liveWireModelName = $attributes->whereStartsWith('wire:model');
    $nameError = $liveWireModelName->get('wire:model.debounce.500ms');
@endphp
<div @if($class) class="{{$class}}" @endif >
    <label for="{{$label}}" class="block text-sm font-medium text-gray-700 leading-5">
        {{$label}}
    </label>

    <div class="mt-1 rounded-md shadow-sm">
        <input {{$liveWireModelName}} id="{{$label}}" type="{{$type}}"
               @if($required) required @endif
               @if($ruleHtml) {{$attributes->get('ruleHtml')}} @endif
               autofocus
               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error($nameError) border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror" />
    </div>

    @error($nameError)
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
