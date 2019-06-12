@extends('layouts.app')

@section('title', 'roles')

@section('content')
<div class="container">

    <h1>List of roles</h1>

    <h2 class="blue">Parameters of the roles:</h2>
    <table class="blue_table">
        <tr>
            <th>#</th>
            <th>id</th>
            <th>name</th>
            <th>display_name</th>
            <th>description</th>
            <th>permissions</th>
            <th>rank</th>
            <th>users</th>
            <th>created</th>
            <th>updated</th>
            <th class="actions3">actions</th>
        </tr>

        @foreach($roles as $i=>$role)

            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->display_name }}</td>
                <td style="max-width: 300px;">{{ $role->description }}</td>
                <td><a href="#perms_{{ $role->name }}">
                    @if ($role->perms())
                        {{ $role->perms()->pluck('display_name')->count() }}
                    @else
                    0
                    @endif
                </a></td>
                <td>{{ $role->rank }}</td>
                <td><a href="#users_{{ $role->name }}">{{ $role->users->count() }}</a></td>
                <td>{{ $role->created_at ?? '-' }}</td>
                <td>{{ $role->updated_at ?? '-' }}</td>
                <td>

                    @if ( Auth::user()->can('view_roles') ) {{--это безумие!!!--}}
                        <a href="{{ route('roles.show', ['role' => $role->id]) }}" class="btn btn-outline-primary">
                            <i class="fas fa-eye"></i>
                        </a>
                    @else
                        <button class="btn btn-outline-secondary"><i class="fas fa-eye"></i></button>
                    @endif


                    @if ( Auth::user()->can('edit_roles') and $role->id > 4 )
                        <a href="{{ route('roles.edit', ['role' => $role->id]) }}" class="btn btn-outline-success">
                            <i class="fas fa-pen-nib"></i>
                        </a>
                    @else
                        <button class="btn btn-outline-secondary"><i class="fas fa-pen-nib"></i></button>
                    @endif


                    @if ( Auth::user()->can('delete_roles') and $role->id > 4 )
                        {{-- <form action="{{ route('roles.destroy', ['role' => $role->id]) }}" method="POST" class="del_btn">
                            @csrf

                            @method("DELETE")

                            @if ( $role->id < 5 )
                                <button type="submit" class="btn btn-outline-secondary">
                            @else
                                <button type="submit" class="btn btn-outline-danger">
                            @endif

                            <i class="fas fa-trash"></i>
                            </button>
                        </form> --}}
                        @modalConfirmDestroy([
                            'btn_class' => 'btn btn-outline-danger del_btn',
                            'cssId' => 'delele_',
                            'item' => $role,
                            'action' => route('roles.destroy', ['role' => $role->id]),
                        ])
                    @else
                        <button class="btn btn-outline-secondary"><i class="fas fa-trash"></i></button>
                    @endif

                </td>
            </tr>

        @endforeach

    </table><br>



    @permission('create_roles')
        <a href="{{ route('roles.create') }}" class="btn btn-outline-primary">create new roles</a><br><br><br>
    @endpermission





    @foreach($roles as $role)
        
        @permission('view_users')
            <h2 class="blue" id="users_{{ $role->name }}">List of users for '{{ $role->name }}' role:</h2>
            @if($role->users->count())
                @foreach($role->users as $user)
                    @if($loop->last){{ $loop->iteration }} <a href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->name }}</a>.
                    @else{{ $loop->iteration }} <a href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->name }}</a>, 
                    @endif
                @endforeach
            @else
                no users for this role
            @endif
            <br><br>
        @endpermission

        @permission('view_permissions')
            <h2 class="blue" id="perms_{{ $role->name }}">Permissions of the '{{ $role->name }}' role:</h2>
            @tablePermissions(['permissions' => $permissions, 'user' => $role])
            <br><br><br>
        @endpermission

    @endforeach


</div>
@endsection
