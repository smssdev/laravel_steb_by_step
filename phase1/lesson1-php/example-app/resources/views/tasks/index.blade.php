<!DOCTYPE html>
<html>
<head>
    <title>قائمة المهام</title>
</head>
<body>
    <h1>قائمة المهام</h1>

    <ul>
        @forelse($tasks as $task)
            <li>
                {{ $task->title }}
                @if($task->completed)
                    - <span style="color: green;">مكتملة</span>
                @else
                    - <span style="color: red;">غير مكتملة</span>
                @endif
            </li>
        @empty
            <li>لا توجد مهام حالياً</li>
        @endforelse
    </ul>
</body>
</html>
