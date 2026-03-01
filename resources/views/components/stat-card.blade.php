@props(['title' => '', 'value' => 0, 'hint' => null, 'icon' => '📊'])

<div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
    <div class="flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $value }}</p>
            @if($hint)
                <p class="mt-1 text-xs text-gray-500">{{ $hint }}</p>
            @endif
        </div>
        <div class="text-2xl">{{ $icon }}</div>
    </div>
</div>