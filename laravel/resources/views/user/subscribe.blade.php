@extends('layouts.app')

@section('header')
    @include('common.header')
@endsection

@section('content')
    <div class="content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Activate Account</h3>
            </div>
            <div class="panel-body text-center">
                <i class="center-block fa fa-envelope fa-5x"></i>
                <h3>Subscribe for only $1 a month! eSurvey will charge you automatically every month.</h3>
                <div class="form-group">
                    <form action="{{ url('subscription/checkout') }}" method="post">
                        {{ csrf_field() }}
                        <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="{{ env('STRIPE_KEY') }}"
                                data-amount="100"
                                data-name="Stripe.com"
                                data-description="Widget"
                                data-locale="auto"
                                data-currency="usd">
                        </script>
                    </form>
                </div>
                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection