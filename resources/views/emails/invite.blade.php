@component('mail::message')
    Hi,
    <br />
    Je ontvangt bij deze een email om lid te worden binnen {{ config('app.name') }} als @if($invite->type === 'mechanic')Fietsenmaker. @elseif ($invite->type === 'location_manager') Locatie manager. @else Bezorgfiets medewerker.@endif
    @component('mail::button', ['url' => $url,'color' => 'success'])
        Klik hier om te registreren
    @endcomponent

    Met vriendelijke groeten,

    {{ config('app.name') }}
@endcomponent
