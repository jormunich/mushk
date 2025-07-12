@component('mail::message')
    {{ __('Hi') }} {{ $user->name }}

    {{ __('You have successfully registered in ') }} {{ config('app.name') }}
    <p><b>{{ __('Your username') }}:</b> {{ $user->email }}</p>
    <p><b>{{ __('Your password') }}:</b> {{ $password }}</p>
    {{ __('You can change you password from your profile') }}

    @component('mail::button', ['url' => route('login')])
        {{ __('Login') }}
    @endcomponent

    {{__('Thanks')}},<br>
    {{ config('app.name') }}
@endcomponent
