@php use Illuminate\Contracts\Auth\MustVerifyEmail; @endphp
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form x-data="imageCropper('Crop Avatar')" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <input type="hidden" x-model="croppedImageBase64" name="cropped_avatar" />

        <x-modal :name="__('Crop Avatar')">
            <section class="p-6 space-y-6">
                <h2 class="text-lg font-medium text-gray-900">Confirm Cropping</h2>

                <div id="cropperContainer"></div>

                <div class="flex justify-end space-x-2">
                    <x-secondary-button type="button" @click="closeModal">Cancel</x-secondary-button>
                    <x-primary-button type="button" @click="cropImage">Crop</x-primary-button>
                </div>
            </section>
        </x-modal>

        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                          required autofocus autocomplete="name"/>
            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                          :value="old('email', $user->email)" required autocomplete="username"/>
            <x-input-error class="mt-2" :messages="$errors->get('email')"/>

            @if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="timezone" :value="__('Timezone')"/>

            <div x-data="timezoneDetector('{{ $user->timezone }}')" class="flex gap-2 mt-1">
                <select
                    id="timezone"
                    name="timezone"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                >
                    @foreach(timezone_identifiers_list() as $timezone)
                        <option
                            x-bind:selected="timezone === '{{ $timezone }}'"
                            value="{{ $timezone }}"
                            @if($user->timezone === $timezone) selected @endif
                        >
                            {{ $timezone }}
                        </option>
                    @endforeach
                </select>

                <x-secondary-button
                    x-on:click="detectTimezone"
                    type="button"
                    @class('shrink-0')
                >
                    {{ __('Detect Timezone') }}
                </x-secondary-button>
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('timezone')"/>
        </div>

        <div>
            <x-input-label for="avatar" :value="__('Avatar')" />
            <x-file-input id="avatar" name="avatar" type="file" accept="image/*" @change="onFileSelect" @class('mt-1') />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div x-show="croppedImageBase64.length > 0" style="display: none;">
            <x-input-label for="preview" :value="__('Preview')" />

            <img :src="croppedImageBase64" id="preview" alt="Cropped Avatar" class="rounded-lg w-20 mt-1" />

            <x-secondary-button type="button" @class('mt-2') @click="reset">Remove</x-secondary-button>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
