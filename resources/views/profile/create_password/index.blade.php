@extends('layouts.backend')

@section('content')
    {{--    TODO:: fix this breadcrumb--}}
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w600 mt-1 mb-0 mb-sm-1">Profiel</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">BEZORGFIETS</li>
                        <li class="breadcrumb-item">Profiel</li>
                        <li class="breadcrumb-item active" aria-current="page">Wachtwoord aanmaken</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="content content-full">
        @include('profile.create_password.template.index')
    </div>
@endsection
@section('js_after')
    @parent
    <script>
        var variables ={
        };
    </script>
@endsection
