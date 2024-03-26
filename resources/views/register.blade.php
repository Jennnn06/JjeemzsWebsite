<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Register</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    *{
        margin: 0;
        padding: 0;
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
      }

      body{
        display: flex; 
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        width:100%;
        background-image: url("../assets/background.jpg");
        background-position: center;
        background-size: cover;
      }

      .logo{
        position: relative;
        display: flex;
        width: 150px;
        height: 100px;
        margin-bottom: 0; 
      }

      .logoimg{
        display: flex;
        flex-direction: column;
        align-items: center;
      }
        
      .logotext{
        font-weight: bold;
        color: black;
        margin-bottom: 25px;
      }

      .formm{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
      }

      .submitt{
        display: flex;
        flex-direction: column;
        align-items: flex-end;
      }
  </style>
</head>
<body>
  <!-- Copied from bootstrap -->
  <div class="container">

    <!-- TIP: Learn bootstrap, Some of the unknown class are from bootstrap -->
    <div class="mt-5">
      @if ($errors->any())
        <div class="col-12">
          @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
          @endforeach  
        </div>
      @endif
    </div>

    <form action="{{route('register.post')}}" method="POST" class="formregister ms-auto me-auto mt-3"  style="width: 500px">
        @csrf

        <div class="mb-3 logoimg">
          <img src="{{ asset('assets/logosample.png') }}" alt="Logo" class="logo">
          <h2 class="logotext">CONSTRUCTION SERVICES</h2>
        </div>

        <div class="mb-3 formm">
          <label class="form-label" style="color: white">Fullname</label>
          <input type="text" class="form-control" name="name">
        </div>

        <div class="mb-3 formm">
            <label for="form-label" class="form-label" style="color: white">Email address</label>
            <input type="email" class="form-control" name="email" >
          </div>

        <div class="mb-3 formm">
          <label for="exampleInputPassword1" class="form-label" style="color: white">Password</label>
          <input type="password" class="form-control" name="password">
        </div>

        <div class="mb-3 submitt">
          <button type="submit" class="btn btn-primary" style="width: 150px; height: 70px; background-color: green; color: #fff; border: none">Submit</button>
        </div>
        
      </form>
  </div>
</body>
</html>