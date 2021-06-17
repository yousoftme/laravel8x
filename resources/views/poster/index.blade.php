<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Poster') }}
        </h2>
    </x-slot>

    <posters-component :posters_prop="{{ json_encode($posters) }}"></posters-component>
</x-app-layout>