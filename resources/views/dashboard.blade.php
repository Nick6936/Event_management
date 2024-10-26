<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .centered-container {
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('event') }}">Event</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('attendee') }}">Attendee</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories') }}">Categories</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <span class="navbar-text me-3">Welcome, {{ Auth::user()->name }}</span>
                    <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
                </form>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="text-center">Welcome to the Dashboard</h1>

        <!-- Events Section -->
        <div class="my-4">
            <h2>Events</h2>
            <ul class="list-group mb-4">
                @foreach($events as $event)
                    <li class="list-group-item">
                        <strong>{{ $event->title }}</strong> - {{ $event->date }} at {{ $event->location }}
                        <p>{{ $event->description }}</p>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Attendees Section -->
        <div class="my-4">
            <h2>Attendees</h2>
            <ul class="list-group mb-4">
                @foreach($attendees as $attendee)
                    <li class="list-group-item">
                        {{ $attendee->name }} - {{ $attendee->email }}
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Categories Section -->
        <div class="my-4">
            <h2>Categories</h2>
            <ul class="list-group">
                @foreach($categories as $category)
                    <li class="list-group-item">
                        {{ $category->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
