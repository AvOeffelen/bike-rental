@if(auth()->user()->isLocationManager())
    <location-manager-index></location-manager-index>
@elseif(auth()->user()->isOwner())
    <location-owner-index></location-owner-index>
@elseif(auth()->user()->isMechanic())
    <location-mechanic-index></location-mechanic-index>
@else

@endif
