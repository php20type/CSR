<!DOCTYPE html>
<html>

    <head>
        <title>New Fund Request</title>
    </head>

    <body>
        <h2>New Fund Request Submitted</h2>
        <p><strong>Name:</strong> {{ $name }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Phone:</strong> {{ $phone }}</p>
        <p><strong>NGO Name:</strong> {{ $ngo_name }}</p>
        <p><strong>Requested Amount:</strong> {{ $cost ?? 'Not specified' }}</p>
        <p><strong>Note:</strong> {{ $note ?? 'No additional notes provided' }}</p>

        <br>
        <p>Please log in to the admin dashboard to review this request.</p>
    </body>

</html>