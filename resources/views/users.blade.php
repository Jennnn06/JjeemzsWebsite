<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'Manager Users')

<!-- Pass the content to layout -->

@section('content')

<!-- jQuery CDN (if not already included) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- JavaScript AJAX Request for SEARCH BAR -->
<script>
    $(document).ready(function() {
        $('#searchUserBar').on('input', function() {
            var searchTerm = $(this).val(); // Get the search query from the input field
            $.ajax({
                url: '{{ route('manageusers') }}', // Route to handle the search request on the server
                method: 'GET',
                data: { search: searchTerm }, // Pass the search query as data
                success: function(response) {
                    $('#usersTable').html(response); // Update the users table with search results
                }
            });
        });
    });
</script>

<script>
    function confirmDelete(userId) {
        console.log('confirmDelete function called with userId:', userId);
        if (confirm('Are you sure you want to delete this user?')) {
            // If the user confirms, submit the form
            document.getElementById('deleteForm_' + userId).submit();
        }
    }
</script>

<!-- Users -->
<div class="p-0" style="flex:1; margin: 30px 20px 0 20px; background-color: #282828;">
    <div style="background-color: #323232; border-radius: 5px; padding: 40px; height:100vh">
        
        <!-- Text and Create-->
        <div style="align-items: flex-start; display:flex; flex-direction:row; justify-content: space-between;">
            <p style="font-size: 25px; color: #f0f0f0;">List of Users</p>
            <a href="{{route('createusers')}}" style="height: 50px; width:150px; margin-bottom: 20px; border-radius: 5px; font-size: 15px; text-decoration: none; color: white; background-color: green; text-align: center; padding-top: 15px; ">
                Create New User
            </a>
        </div>

        <!-- Search bar 
        <form action="#" method="GET">
        </form> -->

        <input name="search" class="form-control" list="datalistOptions" id="searchUserBar" style="display: flex; flex: 1; flex-direction:row; margin-bottom: 20px" placeholder="Type to search...">

        <!-- Table -->
        <div id="usersTable">
            <table class="table table-striped table-hover" >
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
                                <!-- view -> web.php/route -> controller -->
                                <a href="{{ url('users/'.$user ->id.'/editusers') }}" style="text-decoration: none">
                                    @csrf
                                    <i class="fa-solid fa-pencil" style="width: 30px; height: 30px; border-radius: 5px; background-color: green; color:#f0f0f0; display: flex; flex: 1; align-items:center; justify-content: center">
                                    </i>
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
            
            
        </div>
    </div>
</div>
@endsection