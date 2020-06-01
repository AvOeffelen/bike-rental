@if(auth()->user()->isLocationManager())
    <location-manager-bicycle-index></location-manager-bicycle-index>
@else
<bicycle-index></bicycle-index>
@endif
