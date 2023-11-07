<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chirps') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('chirps.store')}}">
                        @csrf
                        <textarea name="message" 
                                  class="block w-full rounded-md border-gray-300 bg-white shadow-sm transition-colors duration-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-indigo-300 dark:focus:ring dark:focus:ring-indigo-200 dark:focus:ring-opacity-50"
                                  placeholder="{{ __('What\'s on your mind?') }}"
                                  >{{ old('message') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('message')"/>
                        <x-primary-button class="mt-4">
                            {{ __('chirp') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
            <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm sounded-lg divide-y dark:divide-gray-900">
                @foreach ($chirps as $chirp)
                    <div class="p-6 flex space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="h-6 w-6 text-gray-600 dark:text-gray-400 -scale-x-100">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />
                        </svg>
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-gray-800 dark:text-gray-200">
                                        {{$chirp->user->name}}
                                    </span>
                                    <small class="ml-2 text-sm text-gray-600 dark:text-gray-400"> {{$chirp->created_at->format('J M Y, g:i a')}} </small>
                                    @unless ($chirp->created_at->eq($chirp->updated_at))
                                        <small class="text-sm text-gray-600 dark:text-gray-400"> 
                                            &middot; {{ __('Edited') }} 
                                        </small>
                                    @endunless

                                </div>
                            </div>
                            <p class="mt-4 text-lg text-gray-900 dark:text-gray-100"> {{$chirp->message}} </p>
                        </div>
                        {{-- Otra manera de validar es con is --}}
                        {{-- @if (auth()->user()->id === $chirp->user_id) --}}
                        {{-- @if (auth()->user()->is($chirp->user)) --}}
                        @can('update', $chirp)
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <button>
                                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                        </svg>
                                        
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    {{-- le pasamos la ruta a la que queremos redireccionar --}}
                                    <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                        {{ __('Edit Chirp') }}
                                    </x-dropdown-link> 
                                    <form method="POST" action="{{ route('chirps.destroy', $chirp) }}">
                                        @csrf @method('DELETE')
                                        <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Delete Chirp') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        {{-- @endif --}}
                        @endcan
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
