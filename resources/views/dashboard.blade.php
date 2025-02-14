<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (Auth::user()->is_admin)
                        <div class="mb-4 font-bold text-lg text-red-600">
                            {{ __("You're an admin!") }}
                        </div>

                        @if (count($unverifiedUsers) > 0)
                            <div class="mb-4 font-bold text-lg text-green-600">
                                <div class="columns-2 items-center gap-4">
                                    @foreach ($unverifiedUsers as $unverifiedUsers)
                                            <div class="flex" style="height: 120px">

                                                <div
                                                    class="flex-none mb-4 font-bold text-lg text-green-600"
                                                    style="min-width: 270px;">

                                                    {{ $unverifiedUsers->name }}<br>
                                                    {{ $unverifiedUsers->email }}
                                                </div>
                                                <div class="flex-none mb-4 font-bold text-lg text-green-600">
                                                    <x-primary-button class="ms-3" style="min-height: 40px"
                                                    onclick="location.href='{{ route('verify', [ 'id' => $unverifiedUsers->id] ) }}'">
                                                        {{ __('VERIFY') }}
                                                    </x-primary-button>
                                                </div>

                                            </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="mb-4 font-bold text-lg text-green-600">
                                {{ __('No users to check!') }}
                            </div>
                        @endif



                    @else
                        <div class="mb-4 font-bold text-lg text-green-600">
                            {{ __('Welcome '. Auth::user()->name . '!') }}
                        </div>


                        @if (count($acceptableFriends) > 0)
                            <div class="mb-4 font-bold text-lg text-green-600">
                                <div class="columns-2 items-center gap-4">
                                    @foreach ($acceptableFriends as $acceptableFriend)

                                        <div class="flex" style="height: 120px">

                                            <div
                                                class="flex-none mb-4 font-bold text-lg text-green-600"
                                                style="min-width: 270px;">
                                                {{ $acceptableFriend->user_name  }}<br>
                                            </div>
                                            <div class="flex-none mb-4 font-bold text-lg text-green-600">
                                                <x-primary-button class="ms-3" style="min-height: 40px"
                                                    onclick="location.href='{{ route('accept', [ 'friend_id' => $acceptableFriend->user_id] ) }}'">
                                                    {{ __('ACCEPT') }}
                                                </x-primary-button>
                                                <x-primary-button class="ms-3" style="min-height: 40px"
                                                    onclick="location.href='{{ route('refuse', [ 'friend_id' => $acceptableFriend->user_id] ) }}'">
                                                    {{ __('REFUSE') }}
                                                </x-primary-button>
                                            </div>

                                        </div>

                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="mb-4 font-bold text-lg text-green-600">
                                {{ __('No friends to check!') }}
                            </div>
                        @endif


                        @if (count($notifications) > 0)
                            <div class="mb-4 mt-10 font-bold text-lg text-green-600">
                                {{ __('Notifications') }}
                            </div>
                            @foreach ($notifications as $notification)
                                <div class="flex" style="height: 50px">
                                    <div
                                        class="flex-none mb-4 font-bold text-lg text-green-600"
                                        style="min-width: 270px;">
                                        {{ $notification->created_at  }}
                                    </div>
                                    <div
                                        class="flex-none mb-4 font-bold text-lg text-green-600"
                                        style="min-width: 270px;">
                                        {{ $notification->message  }}
                                    </div>
                                </div>

                            @endforeach
                        @else
                            <div class="mb-4 font-bold text-lg text-green-600">
                                {{ __('There are no notifications!') }}
                            </div>
                        @endif



                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
