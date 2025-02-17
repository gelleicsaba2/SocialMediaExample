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

                        @if (count($users) > 0)
                            <div class="mb-4 font-bold text-lg text-green-600">
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach ($users as $user)


                                            <div class="flex">

                                                <div
                                                    class="flex-none mb-4 font-bold text-lg text-green-600"
                                                    style="min-width: 200px;">
                                                    {{ $user->name }}
                                                </div>
                                                <div class="flex-none mb-4 font-bold text-lg text-green-600">
                                                    @if ($user->markable)
                                                        <x-primary-button class="ms-3"
                                                            onclick="location.href='{{ route('people.mark', ['friend_id' => $user->id] ) }}'">
                                                            {{ __('MARK AS FRIEND') }}
                                                        </x-primary-button>
                                                    @endif
                                                </div>

                                            </div>

                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="mb-4 font-bold text-lg text-green-600">
                                {{ __('No people found!') }}
                            </div>
                        @endif

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
