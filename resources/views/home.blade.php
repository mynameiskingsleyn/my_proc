@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Books App</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    Welcome to books app
                    <p>
                      <a href="{{route('requestToken')}}"
                      onclick="event.preventDefault();
                              document.getElementById('token_form').submit();">request Token</a>
                    </p>
                    <form class="" id='token_form' action="{{route('requestToken')}}" method="post">
                        {{ csrf_field() }}
                    </form>
                </div>
                <div class="card-footer">
                  @if(Session::has('flash_message'))
                      {{Session::get('flash_message')}}
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
