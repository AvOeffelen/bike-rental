@if(auth()->user()->isLocationManager())
    <location-manager-overview :location="{{$location}}"></location-manager-overview>
@elseif(auth()->user()->isOwner())
    <location-overview :location="{{$location}}"></location-overview>
@else
{{--    Else--}}
@endif
