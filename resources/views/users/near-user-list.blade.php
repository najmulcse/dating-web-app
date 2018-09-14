@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Users list of around 5km distance</h2>
                    </div>
                    <div class="card-body">
                        @if(session('message'))
                            <div class="alert alert-success">
                                {{session('message')}}
                            </div>
                        @endif
                        <table class="table table-striped">
                            @if(count($users))
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Email</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Age</th>
                                <th scope="col">Distance</th>
                            </tr>
                            </thead>
                            @endif
                            <tbody>
                            @forelse($users as $id => $user)
                                <tr>
                                    <th scope="row">{{ ++$id }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <img src="{{ $user->avatar }}" alt="Picture" height="200px" width="100px">
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->gender }}</td>
                                    <td>{{ $user->age }}</td>
                                    <td></td>
                                </tr>
                            @empty
                                <h4> No user available</h4>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



@stop
