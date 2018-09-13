@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>All Users</h2>
                    </div>
                    <div class="card-body">
                        @if(session('is_mutual'))
                            <div class="alert alert-success">

                                {{session('is_mutual')}}
                            </div>
                        @endif
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Email</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Age</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
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
                                <td>{{ $user->age }} year(s)</td>
                                <td>
                                    <a  data-action="{{ route('like.createOrToggle') }}"
                                        href=""
                                        class="btn-link like-unlike"
                                        data-id="{{ $user->id }}">
                                        {{ Auth::user()->isLiked($user->id) ? 'Unlike':'Like' }}
                                    </a>
                                </td>
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

@section('scripts')

    <script>
        $(document).ready( function(){
           $('.like-unlike').on('click', function(e){
               e.preventDefault();
               let url = $(this).attr('data-action');
               let id = $(this).attr('data-id');
               let data = {
                   id :id
               }
               axios.post(url,data).then(function( response){
                    console.log(response.data.is_mutual);

                    if(response.data.is_mutual === true){
                        alertify.alert("Matched! Both of you liked each other.");
                    }
                   alertify.success("Status updated");
                   setTimeout(function(){
                       window.location.reload();
                   }, 2000);
               }).catch(function(error){

               });
           });

        });
    </script>
@stop