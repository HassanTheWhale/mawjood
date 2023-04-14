@extends('admin.layouts.master')

@section('scripts')
    <script src="{{ asset('admin/ovendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/ovendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/js/demo/datatables-demo.js') }}"></script>
@endsection

@section('content')
    <h2>Events</h2>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Picture</th>
                    <th>Is Private</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr>
                        <td>{{ $event->name }}</td>
                        <td>{{ $event->description }}</td>
                        <td>{{ $event->categoryName }}</td>
                        <td><img src="{{ asset($event->picture) }}" width="64px" alt="{{ $event->name }} Picture"></td>
                        <td>{{ $event->private ? 'yes' : 'no' }}</td>
                        <td>{{ $event->start_date }}</td>
                        <td>{{ $event->end_date }}</td>
                        <td><a href="{{ route('admin.removeEvent', $event->id) }}">Remove</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
