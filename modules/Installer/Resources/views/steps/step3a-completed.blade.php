@extends('installer::app')
@section('title', 'Installation Completed!')

@section('content')
    <div style="align-content: center;">
        {!! Form::open(['route' => 'installer.complete', 'method' => 'GET']) !!}

        <h4>Install Completed!</h4>

        <p>Click the button to proceed to the login screen!</p>

        <p style="text-align: right">
            {!! Form::submit('Install Complete! Continue to Log-In >>',
                             ['class' => 'btn btn-success'])
            !!}
        </p>
        {!! Form::close() !!}
    </div>
@endsection
