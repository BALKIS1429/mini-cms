@props([
    'title',
    'subtitle' => null,
])

<header class="mb-8">
    <h1 class="text-3xl font-bold">{{ $title }}</h1>

    @if ($subtitle)
        <p class="mt-2 text-gray-600">{{ $subtitle }}</p>
    @endif
</header>
