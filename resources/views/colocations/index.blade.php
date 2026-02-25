<!DOCTYPE html>
<html>
<head>
    <title>Colocations</title>
</head>
<body>

<h1>Mes colocations</h1>

@foreach($colocations as $colocation)
    <div>
        {{ $colocation->name }}
    </div>
@endforeach

</body>
</html>