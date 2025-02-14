<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('People') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (! Auth::user()->is_admin)

                        <div class="mb-4 font-bold text-lg">
                            <div class="grid grid-cols-2 gap-4">

                                <div class="text-green-600">
                                    {{ $friend->name }}
                                </div>
                                <div class="text-green-600">
                                    {{ $friend->email }}
                                </div>
                                <div>
                                    <x-primary-button class="ms-3" style="min-height: 40px"
                                    onclick="location.href='{{ route('delete', [ 'friend_id' => $friend->id] ) }}'">
                                        {{ __('DELETE') }}
                                    </x-primary-button>
                                </div>
                                <div>
                                    <a href="{{ route('friends') }}" class="ms-3"
                                        class="text-blue-600 hover:text-blue-400 decoration-solid"
                                        style="text-decoration: underline; ">
                                        {{ __('back') }}
                                    </a>
                                </div>

                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
