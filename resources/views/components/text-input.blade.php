@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-400 bg-gray-50 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm']) }}>
