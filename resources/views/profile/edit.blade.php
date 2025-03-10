<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="my-6 md:my-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8
                    grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:flex xl:gap-6">
            <!-- Profile Information -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg xl:flex-1">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg xl:flex-1">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg sm:col-span-1 md:col-span-2 lg:col-span-2 xl:flex-1">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
