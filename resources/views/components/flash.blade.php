@props(['class' => ''])

@if (session('success'))
    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700 {{ $class }}">
        <div class="flex items-start gap-2">
            <span class="mt-0.5">✅</span>
            <div>{{ session('success') }}</div>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700 {{ $class }}">
        <div class="flex items-start gap-2">
            <span class="mt-0.5">⚠️</span>
            <div>{{ session('error') }}</div>
        </div>
    </div>
@endif