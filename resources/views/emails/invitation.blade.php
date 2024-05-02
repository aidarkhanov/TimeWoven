<!DOCTYPE html>
<html>
<head>
    <title>Event Invitation</title>
</head>
<body>
<h1>You are invited!</h1>
<p>You have been invited to join the event: <strong>{{ $eventTitle }}</strong>.</p>
<p>Description: {{ $eventDescription }}</p>
<p>Please respond to the invitation by clicking one of the links below:</p>
<ul>
    <li><a href="{{ $responseUrl }}?response=accepted">Accept</a></li>
    <li><a href="{{ $responseUrl }}?response=declined">Decline</a></li>
    <li><a href="{{ $responseUrl }}?response=maybe">Maybe</a></li>
</ul>
</body>
</html>
