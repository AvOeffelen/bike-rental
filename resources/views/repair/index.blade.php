@extends('layouts.backend')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w600 mt-1 mb-0 mb-sm-1">Repair</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">BEZORGFIETS</li>
                        <li class="breadcrumb-item active" aria-current="page">Repair</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content content-full">
        @include('repair.template.index')
    </div>
@endsection
@section('js_after')
    @parent
    <script>
        var variables ={
            get_bicycles: '{{url('axios/bicycle/list/get')}}',
        };
    </script>
@endsection
