@extends('layouts.master')

@section('content')
    <div class="landing">
        <div class="h-100 d-flex justify-content-center align-items-center flex-column text-center">
            <div class="card w-75 py-5 certificate-body">
                <h2 class="certificate-logo">Mawjood</h2>

                <div class="certificate-title">
                    Certificate of Attending
                </div>

                <div class="certificate-assignment">
                    This certificate is presented to
                </div>

                <div class="certificate-person">
                    {{ $myuser->name }}
                </div>

                <div class="certificate-reason">
                    As he attended {{ $attend }}/{{ $eventInstances }} assembly(ies) in:
                    <br> {{ $event->name }}
                </div>
            </div>
        </div>
    </div>
@endsection
