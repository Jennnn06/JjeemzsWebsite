<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'Edit User')

<!-- Pass the content to layout -->
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // Initially hide the password field
        $('#passwordFieldLabel').hide();
        $('#passwordField').hide();

        // Listen for change in the checkbox state
        $('#defaultCheck1').change(function() {
            if ($(this).is(':checked')) {
                // If the checkbox is checked, show the password field
                $('#passwordFieldLabel').show();
                $('#passwordField').show();
            } else {
                // If the checkbox is unchecked, hide the password field
                $('#passwordFieldLabel').hide();
                $('#passwordField').hide();
            }
        });
    });
</script>

<div class="p-0" style="flex:1; margin: 30px 20px 0 20px; background-color: #282828;">
    <div style="background-color: #323232; border-radius: 5px; padding: 40px; height:100vh">
        
        <!-- Text and Create-->
        <div style="align-items: flex-start; display:flex; flex-direction:row; justify-content: space-between;">
            <p style="font-size: 25px; color: #f0f0f0;">Edit user info of: {{$usersTable->name}}</p>
        </div>
        
        <div style="margin-left: 20px; margin-top: 20px">
        <form method="post" action="{{ url('users/' .$usersTable->id. '/editusers') }}">
            @csrf
            @method('PUT')

            <!-- ID -->
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label" style="color: #f0f0f0">ID</label>
                <input class="form-control" type="text" value="{{$usersTable->id}}" aria-label="Disabled input example" disabled style="width: 300px">
            </div>
            
            <!-- Username -->
            <div class="mb-3 row">
                <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Username</label>
                    <!-- Kinukuha tong variable($user) sa User Controller -->
                <input class="form-control" name="name" type="text" value={{$usersTable->name}} style="width: 300px">
                <span id="usernameHelpInline" class="col-sm-2 form-text" style="color: #f0f0f0; width: 300px">Choose a unique username.</span>

              </div>

            <!-- Email -->
            <div class="mb-3 row">
                <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Email address</label>
                <input type="email" class="form-control" name="email" id="exampleFormControlInput1" value={{$usersTable->email}} style="width: 300px">
                <span id="emailHelpInline" class="col-sm-2 form-text" style="color: #f0f0f0; width: 300px">Enter a valid email address.</span>
            </div>

            <!-- Password -->
            <div style="display: flex; flex-direction: row; margin-top: 40px">
                <label class="col-sm-2 form-check-label" for="defaultCheck1" style="color: #f0f0f0;">Change Password</label>
                <input type="checkbox" id="defaultCheck1" style="width: 25px; height: 25px; margin-top: 5px; border-radius: 10px">
              </div>

            <div class="mb-3 row" style="margin-top: 30px" id="passwordFieldLabel">
                <label for="changePasswordCheckbox" class="col-sm-2" style="color: #f0f0f0;">Input Password</label>
                <input type="password" class="form-control" name="password" aria-describedby="passwordHelpInline" id="passwordField" style="width: 300px; display: none;">
                <span id="passwordHelpInline" class="col-sm-2 form-text" style="color: #f0f0f0; width: 300px">Must be 8-20 characters long.</span>
            </div>

            <!-- Submit button -->
            <div style="margin-left: 360px; margin-top:50px">
                <input type="submit" class="btn btn-primary mb-3" style="width: 100px; height: 45px; background-color: #779933; color: #fff">
            </div>
        </form>
    </div>
</div>
@endsection