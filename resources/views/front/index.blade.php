<!DOCTYPE html>
<html>
<head>
    <title>Laravel 5.8 CRUD Application</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
</head>
<body>
  
<div class="container" style="margin:40px auto">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="">
                bac : {{$bacs}}
            </div>
            <div class="pull-left">
                <h2>Laravel 5.8 CRUD Example from scratch</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href=""> Create New Product</a>
            </div>
        </div>
    </div>
   
    
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Birthday</th>
            <th width="280px">Action</th>
        </tr>
        
        @foreach($list as $key => $item)
        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->birthday}}</td>
            <td>
                <form action="" method="POST">
   
                    <a class="btn btn-info" href="">Show</a>
    
                    <a class="btn btn-primary" href="">Edit</a>

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
   
</body>
</html>