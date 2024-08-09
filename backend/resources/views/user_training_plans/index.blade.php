<!DOCTYPE html>
<html>
<head>
    <title>Assigned Training Plans</title>
</head>
<body>
<h1>Assigned Training Plans</h1>
<ul>
    @foreach ($assignedPlans as $plan)
        <li>{{ $plan['training_plan']['name'] }}</li>
    @endforeach
</ul>
</body>
</html>
