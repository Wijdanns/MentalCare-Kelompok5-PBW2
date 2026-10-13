@props(['small' => false])

<a href="{{ url('/') }}" class="flex items-center gap-3">
    <span class="flex items-center justify-center rounded-xl bg-primary text-white {{ $small ? 'h-8 w-8' : 'h-9 w-9' }}">
        <svg class="{{ $small ? 'h-4 w-4' : 'h-5 w-5' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
        </svg>
    </span>
    <span class="font-bold text-primary {{ $small ? 'text-lg' : 'text-xl' }}">MentalCare</span>
</a>