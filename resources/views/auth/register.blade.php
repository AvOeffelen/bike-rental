@extends('layouts.login')

@section('content')
    {{--    TODO:: fix the bg image.--}}
    <div class="bg-image">
        <div class="row no-gutters bg-primary-op">
            <!-- Main Section -->
            <div class="hero-static col-md-6 d-flex align-items-center bg-white">
                <div class="p-3 w-100">
                    <!-- Header -->
                    <div class="mb-3 text-center">
                        <a class="link-fx font-w700 font-size-h1" href="#">
                            <span class="text-dark">BEZORG</span><span class="text-primary">FIETS</span>
                        </a>
                        <p class="text-uppercase font-w700 font-size-sm text-muted"></p>
                    </div>
                    <div class="row no-gutters justify-content-center">
                        <div class="col-sm-8 col-xl-6">
                            <form action="{{action('SignUpController@finishSignUp',$invite)}}" method="POST">
                                @csrf
                                <div class="py-2">
                                    @if($invite->used !== 0)
                                        <div class="text-center">
                                            <span class="help-block">
                                                <strong
                                                    class="text-danger">Invite is already used by someone else.</strong>
                                            </span>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="name">Voornaam <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control form-control-alt form-control-lg {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                               id="name" name="name" placeholder="Voornaam" value="{{ old('name') }}">
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="addition">Tussenvoegsel <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control form-control-alt form-control-lg {{ $errors->has('addition') ? 'is-invalid' : '' }}"
                                               id="addition" name="addition" value="{{ old('addition') }}"
                                               placeholder="Tussenvoegsel">
                                        @if ($errors->has('addition'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('addition') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname">Achternaam <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control form-control-alt form-control-lg {{ $errors->has('lastname') ? 'is-invalid' : '' }}"
                                               id="name" name="lastname" placeholder="Achternaam"
                                               value="{{ old('lastname') }}">
                                        @if ($errors->has('lastname'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('lastname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-mail <span class="text-danger">*</span></label>
                                        <input type="email"
                                               class="form-control form-control-lg form-control-alt {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                               id="email" name="email" placeholder="E-mail" value="{{ old('email') }}">
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                            </span>
                                    @endif
                                    <div class="form-group">
                                        <label for="phone">Telefoonnummer <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control form-control-lg form-control-alt {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                               id="phone" name="phone"
                                               placeholder="Telefoonnummer" value="{{ old('phone') }}">
                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Wachtwoord <span class="text-danger">*</span></label>
                                        <input type="password"
                                               class="form-control form-control-lg form-control-alt {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                               id="password" name="password"
                                               placeholder="Password">
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="password-confirm">Herhaal wachtwoord <span
                                                class="text-danger">*</span></label>
                                        <input type="password"
                                               class="form-control form-control-lg form-control-alt {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                               id="password-confirm" name="password_confirmation"
                                               placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-hero-lg btn-hero-primary">
                                        <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Registreer
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <!-- END Sign In Form -->
                </div>
            </div>
            <!-- END Main Section -->

            <!-- Meta Info Section -->
            <div
                class="hero-static col-md-6 d-none d-md-flex align-items-md-center justify-content-md-center text-md-center">
                <div class="p-3">
                    <p class="display-4 font-w700 text-white mb-3">
                        Wist je dat...
                    </p>
                    <p class="text-uppercase font-w700 font-size-sm text-white">Als je alle fietsen in nederland achter
                        elkaar zet je een rij van 30.000km hebt?</p>
                    <p class="font-size-lg font-w600 text-white-75 mb-0">
                        Copyright &copy; <span data-toggle="year-copy"></span>
                    </p>
                </div>
            </div>
            <!-- END Meta Info Section -->
        </div>
    </div>
@endsection
