<!DOCTYPE html>
<html>
<head>
    <title>Generate PDF Laravel 9 - NiceSnippets.com</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<style type="text/css">
    h2{
        text-align: center;
        font-size:22px;
        margin-bottom:50px;
    }
    body{
        background:#f2f2f2;
    }
    .section{
        margin-top:30px;
        padding:50px;
        background:#fff;
    }
    .pdf-btn{
        margin-top:30px;
    }
</style>
<body>
<div class="container">
    <div class="col-md-8 section">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2>Laravel 9 Generate PDF - NiceSnippets.com</h2>
            </div>
            <div class="panel-body">
                <div class="main-div">
                    <h1>{{ $title }}</h1>
                    <p>{{ $date }}</p>
                </div>
            </div>
            <div class="text-center pdf-btn">
            </div>
        </div>
    </div>
</div>
</body>
</html>
