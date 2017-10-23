<!DOCTYPE html>
<html>
<head>
	<title>Inquiry</title>
</head>
<body>
    Greetings, you have received an inquiry/feedback.<br>
    <dl>
    	<dt>Subject: </dt> <dd> {{$send->subject}} </dd>
        <dt>From: </dt> <dd> {{$send->name}} </dd>
        <dt>Email: </dt> <dd> {{$send->email}} </dd> 
        <dt>Message: </dt> <dd> {{$send->message}} </dd>
    </dl>

</body>
</html>
