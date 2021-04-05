<!DOCTYPE html>
<html>
<head>

    <title>Laravel 5.8 CRUD Application</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}">
</head>
<body>
  
<div class="container" style="margin:40px auto">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Building 5 sao</h2>
            </div>
            <div class="pull-right">
                {{-- <a class="btn btn-success" href=""> Create New Product</a> --}}
            </div>
        </div>
    </div>
   

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
           
            <th>5 SAO (benefit >= 30)</th>
        </tr>
        
        @foreach($list as $key => $item)
        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$item->name}} ({{$item->architects}})</td>
            <th>
                <label class="switch">
                  <input type="checkbox" {{$item->isBuildingActive?'checked':''}}>
                  <span class="slider round"></span>
                </label>
            </th>
        </tr>
        @endforeach
    </table>
</div>

</body>
</html>