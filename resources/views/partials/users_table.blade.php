<!-- users_table.blade.php -->
<table class="table table-striped table-hover">
    <thead>
        <th style="border-top-left-radius: 5px;">ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Edit</th>
        <th style="border-top-right-radius: 5px;">Delete</th>
    </thead>
    <tbody class="table-group-divider">
        @foreach($usersTable as $user)
            <tr>
                <td>{{$user ->id}}</td>
                <td>{{$user ->name}}</td>
                <td>{{$user ->email}}</td>

                <!-- Edit User -->
                <td>
                    <a href="{{ url('users/'.$user ->id.'/editusers') }}" style="text-decoration: none">
                        <i class="fa-solid fa-pencil" style="width: 30px; height: 30px; border-radius: 5px; background-color: green; color:#f0f0f0; display: flex; flex: 1; align-items:center; justify-content: center"></i>
                    </a>
                </td>

                <!-- Conditionally render Delete User -->
                @if($user->id !== auth()->id())
                    <form id="deleteForm_{{ $user->id }}" method="POST" action="{{ route('user.delete', ['user' => $user->id]) }}">
                        @csrf
                        @method('DELETE')
                        <td>
                            <a href="#" onclick="confirmDelete({{ $user->id }})" style="text-decoration: none">
                                <i class="fa-solid fa-xmark" style="width: 30px; height: 30px; border-radius: 5px; background-color: red; color:#f0f0f0; display: flex; flex: 1; align-items:center; justify-content: center"></i>
                            </a>
                        </td>
                    </form>
                @else
                    <td></td> <!-- Empty cell for the Delete button -->
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
