<!-- TIP: ('folder/layout based on the folder and name') -->
@extends('layout')

<!-- Pass the title to layout -->
@section('title', 'Create User')

<!-- Pass the content to layout -->
@section('content')
<div class="p-0" style="flex:1; margin: 30px 20px 0 20px; background-color: #282828;">
    <div style="background-color: #323232; border-radius: 5px; padding: 40px; height:100vh">
        
        <!-- Text and Create-->
        <div style="align-items: flex-start; display:flex; flex-direction:row; justify-content: space-between;">
            <p style="font-size: 25px; color: #f0f0f0;">Create user</p>
        </div>
        
        <div style="margin-left: 20px; margin-top: 20px">
        <form method="post" action="{{ route('createfunction.post') }}">
            @csrf
            
            <!-- Username -->
            <div class="mb-3 row">
                <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Username</label>
                    <!-- Kinukuha tong variable($user) sa User Controller -->
                <input class="form-control" name="name" type="text" placeholder="Enter Username" style="width: 300px">
                <span id="usernameHelpInline" class="col-sm-2 form-text" style="color: #f0f0f0; width: 300px">Choose a unique username.</span>

              </div>

            <!-- Email -->
            <div class="mb-3 row">
                <label for="exampleFormControlInput1" class="col-sm-2 form-label" style="color: #f0f0f0">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="Enter email" style="width: 300px">
                <span id="emailHelpInline" class="col-sm-2 form-text" style="color: #f0f0f0; width: 300px">Enter a valid email address.</span>
            </div>

            <!-- Password -->
            <div class="mb-3 row">
                <label for="inputPassword6" class="col-sm-2 form-label" style="color: #f0f0f0">Password</label>
                <input type="password" name="password" class="form-control" aria-describedby="passwordHelpInline" placeholder="Enter password" style="width: 300px">
                <span id="passwordHelpInline" class="col-sm-2 form-text" style="color: #f0f0f0; width: 300px">Must be 8-20 characters long.</span>
                <!--$user->password-->
            </div>

            <div style="margin-left: 360px; margin-top:50px">
                <input type="submit" class="btn btn-primary mb-3" style="width: 100px; height: 45px; background-color: #779933; color: #fff">
            </div>
        </form>
    </div>
</div>
@endsection