@extends('heafoo')

@section('page-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <section>
                    <h3 class ="font-bold  text-2xl">Wilkommen auf BSWeb</h3>
                    <p class="text-gray-100 pt-2"> Wenn Sie Kapitän oder Staffelleiter sind, können Sie sich hier anmelden</p>
                </section>
                <section class="mt-10">
                    <form class="flex flex-col" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="block text-gray-100 text-sm font-bold mb-2 ml-3">{{ __('E-Mail:') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror bg-gray-100 text-gray-900 rounded w-full focus:outlie-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="block text-gray-100 text-sm font-bold mb-2 ml-3">{{ __('Passwort:') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror bg-gray-100 text-gray-900 rounded w-full focus:outlie-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Angemeldet bleiben') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary bg-green-500 hover:bg-green-700 font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200">
                                    {{ __('Anmelden') }}
                                </button>
                            </div>
                            <div class="col-md-8 offset-md-4">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link text-sm text-green-500 hover:text-green-700 over:underline mb-6" href="{{ route('password.request') }}">
                                        {{ __('Passwort vergessen') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
