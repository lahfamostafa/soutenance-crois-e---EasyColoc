@props(['status' => 'inactive'])

@php
    $isActive = $status === 'active';
@endphp

<span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold
    {{ $isActive ? 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200' : 'bg-gray-100 text-gray-700 ring-1 ring-gray-200' }}">
    <span class="h-1.5 w-1.5 rounded-full {{ $isActive ? 'bg-emerald-600' : 'bg-gray-500' }}"></span>
    {{ ucfirst($status) }}
</span>