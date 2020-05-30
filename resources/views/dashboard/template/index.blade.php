@if(auth()->user()->isLocationManager())
    <location-manager-dashboard></location-manager-dashboard>
@elseif(auth()->user()->isOwner())
    <owner-dashboard></owner-dashboard>
@elseif(auth()->user()->isMechanic())
    <mechanic-dashboard></mechanic-dashboard>
@else

@endif
