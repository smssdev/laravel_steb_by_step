<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>About</title>
</head>
<body>
    <h1>about page</h1>

    <h4>Name: {{$name}}</h4>
    <h4>Age: {{$age}}</h4>
    <h4>Hoppies:
        <ul>
            @foreach($hobbies as $hobby)
                <li>{{ $hobby }}</li>
            @endforeach
        </ul>
    </h4>
</body>
</html>
