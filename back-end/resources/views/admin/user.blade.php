@extends('admin.layouts.master')

@section('scripts')
    <script src="{{ asset('admin/ovendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/ovendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/js/demo/datatables-demo.js') }}"></script>
@endsection

@section('content')
    <h2>Users</h2>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>username</th>
                    <th>picture</th>
                    <th>Verification picture</th>
                    <th>email</th>
                    <th>verified</th>
                    <th>admin</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td><img src="{{ asset($user->picture) }}" width="64px" alt="{{ $user->username }} Picture"></td>
                        <td>
                            <img src="{{ asset($user->vpicture) }}" width="64px" alt="{{ $user->name }} Picture">
                        </td>

                        <td>{{ $user->email }}</td>
                        <td>{{ $user->verified }}</td>
                        <td>{{ $user->is_admin ? 'yes' : 'no' }}</td>
                        <td><a href="{{ route('admin.removeUser', $user->id) }}">Remove</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
