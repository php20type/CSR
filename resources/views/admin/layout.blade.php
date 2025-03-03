<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    @yield('style')
</head>
<body>
    @include('admin.header')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" style="padding-left: 0px;">
                @include('admin.sidebar')
            </div>
            <div class="col-md-10">
                <div class="p-3">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @include('admin.footer')
</body>
</html>
