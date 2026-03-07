@props(['active' => false, 'icon', 'href'])

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => 'flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all ' .
   ($active
       ? 'bg-gray-800 text-white border border-gray-700 shadow-sm'
       : 'text-gray-400 hover:bg-gray-800 hover:text-gray-200')]) }}>

    <i class="fa-solid {{ $icon }} {{ $active ? 'text-amber-400' : 'text-gray-500' }}"></i>

    <span>{{ $slot }}</span>
</a>
