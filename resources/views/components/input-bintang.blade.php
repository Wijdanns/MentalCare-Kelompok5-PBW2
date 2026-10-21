{{--
    Pilihan rating 1-5 bintang untuk form. Mengirim input bernama "rating".
    Pemakaian: <x-input-bintang :nilai="old('rating', 0)" />
--}}
@props(['nilai' => 0])

<div x-data="{ nilai: {{ (int) $nilai }}, sorot: 0 }" class="flex items-center gap-1" role="radiogroup" aria-label="Rating">
    <input type="hidden" name="rating" :value="nilai || ''">

    <template x-for="n in 5" :key="n">
        <button type="button" role="radio" :aria-checked="nilai === n" :aria-label="n + ' bintang'"
                @click="nilai = n" @mouseenter="sorot = n" @mouseleave="sorot = 0"
                class="rounded p-0.5 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-primary">
            <svg class="h-8 w-8 transition" :class="n <= (sorot || nilai) ? 'text-amber-400' : 'text-gray-200'" viewBox="0 0 24 24" fill="currentColor"><path d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006Z"/></svg>
        </button>
    </template>

    <span class="ml-2 text-sm text-gray-500" x-show="nilai > 0" x-cloak x-text="nilai + ' dari 5'"></span>
</div>