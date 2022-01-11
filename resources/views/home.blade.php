@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <input type="hidden" id="user_id" name="user_id" value="{{ Auth::id() }}" />
                    <div id="app">
                        <home-component></home-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
