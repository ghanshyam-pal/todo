<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="{{ url('/') }}">

    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{asset('js/sweetalert2/sweetalert2.min.js')}}"></script>
    <link href="{{asset('js/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet">    
    <link rel="stylesheet" href="{{asset('css/style.css') }}">    
</head>
    <body>
        <script type="text/javascript">
            var _token = '{{ csrf_token() }}';
        </script>

        <div class="container">
            <div class="todo-app">
                <div class="app-title">
                    <h2>Laravel Practice app </h2>
                    <i class="fa-solid fa-book-bookmark"></i>
                    <a href="{{url('logout')}}">Logout</a>
                </div>
                <div class="row">
                    <p class="p">All</p>
                    <p>Completed</p>
                    <p>Incompleted</p>
                    <p>Trash</p>
                </div>
                <div class="row">
                    <form action="{{url('save')}}" class="add-task-form" method="post">
                        @csrf
                        <input type="text" id="input-box" name="task" placeholder="add your tasks">
                    </form>
                    <button id="add">Add</button>
                </div>
                <ul id="list-container">
                   
                </ul>
            </div>
        </div>
       


        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>