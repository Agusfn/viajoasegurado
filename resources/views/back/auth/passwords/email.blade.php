@extends('back.layouts.main-auth')

@section('title', 'Reestablecer contraseña')

@section('content')
            <div style="padding: 1px 25px 1px 25px">
                <h3 style="text-align: center; font-weight: 300;margin-bottom: 25px">Reestablecer contraseña</h3>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Dirección e-mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Enviar link reestablecimiento</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
@endsection
