<!DOCTYPE html>
<html>
<body>

<form action="{{ url('/upload') }}" method="post" enctype="multipart/form-data">
	{!! csrf_field() !!}
	<input type="text" name="campaign"><br>
    Select image to upload:<br>
    <input type="file" name="avatar" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>