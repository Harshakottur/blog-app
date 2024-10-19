@extends('layouts.app')

@section('content')
<div class="container">
    <div class="admin-table fade-in">
        <div class="d-flex justify-between align-items-center mb-3">
            <h1>User List</h1>
        </div>

        <div class="responsive-table">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Is Admin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                            <td>
                                @can('edit', $user)
                                    <a href="{{ route('admin.users.edit', $user->id) }}">
                                        <button>Edit</button>
                                    </a>
                                @endcan

                                @can('delete', $user)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn-delete">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
