@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Por favor, verifique o seu e-mail.</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Enviamos um link de verificação para o seu e-mail.
                        </div>
                    @endif

                    Antes de continuar, por favor, verifique o link recebido por e-mail.
                    Se você não recebeu o e-mail,
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">clique aqui para enviar outro</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
