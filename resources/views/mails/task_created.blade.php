<!DOCTYPE html>
<html>
<head>
    <title>Yeni Görev Oluşturuldu</title>
</head>
<body>
    <h1>Yeni Görev Oluşturuldu!</h1>
    <p>
        Merhaba {{ $task->user->name }},<br>
        Yeni bir görev oluşturuldu.<br>
        Görev Zamanı: {{ $task->task_time }}<br>
        Başlık: {{ $task->title }}<br>
        Konu: {{ $task->subject }}<br>
    </p>
</body>
</html>
