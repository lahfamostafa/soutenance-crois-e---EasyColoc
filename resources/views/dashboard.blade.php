<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <h1>Dashboard</h1>

<p>Bienvenue {{ auth()->user()->name }}</p>

<a href="{{ route('colocations.index') }}">Voir mes colocations</a>
</x-app-layout>
