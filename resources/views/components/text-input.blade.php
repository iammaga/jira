@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm py-2 px-2']) !!}>
