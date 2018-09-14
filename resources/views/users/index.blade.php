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
                                    <img src="{{ $user->avatar ?$user->avatar : asset('img/user.png') }}" alt="image" class="img-fluid zoom-image">
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->gender }}</td>
                                <td>{{ $user->age }} year(s)</td>
                                <td>
                                    <a  data-action="{{ route('like.storeOrToggle') }}"
                                        href=""
                                        class="btn-link like-unlike"
                                        data-id="{{ $user->id }}">
                                        {{ Auth::user()->isLiked($user->id) ? 'Dislike':'Like' }}
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

                    alertify.success( response.data.is_like === true ? 'Liked' : 'Disliked');
                    if(response.data.is_mutual === true){
                        alertify.alert("It's a Match!");
                    }
                    console.log(response);
                   setTimeout(function(){
                       window.location.reload();
                   }, 1000);
               }).catch(function(error){

               });
           });

        });
    </script>
@stop
