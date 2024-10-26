<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendee Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center">Attendee Management</h1>
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
                            <a class="nav-link active" href="{{ route('attendee') }}">Attendee</a>
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

        <!-- Add Attendee Form -->
        <div class="my-4">
            <h2>Add New Attendee</h2>
            <form id="addAttendeeForm">
                <div class="mb-3">
                    <label for="addName" class="form-label">Attendee Name</label>
                    <input type="text" class="form-control" id="addName" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="addEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="addEmail" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="addEvent" class="form-label">Select Event</label>
                    <select class="form-select" id="addEvent" name="event_id" required>
                        <option value="">Select an event</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Add Attendee</button>
            </form>
        </div>

        <!-- Edit Attendee Form -->
        <div class="my-4" style="display: none;" id="editAttendeeSection">
            <h2>Edit Attendee</h2>
            <form id="editAttendeeForm">
                <input type="hidden" id="editAttendeeId">
                <div class="mb-3">
                    <label for="editName" class="form-label">Attendee Name</label>
                    <input type="text" class="form-control" id="editName" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="editEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="editEmail" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="editEvent" class="form-label">Select Event</label>
                    <select class="form-select" id="editEvent" name="event_id" required>
                        <option value="">Select an event</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Update Attendee</button>
                <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
            </form>
        </div>

        <!-- Display Attendees -->
        <div class="my-4">
            <h2>Attendees List</h2>
            <ul class="list-group" id="attendeesList"></ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function fetchAttendees() {
            axios.get('/api/attendees')
                .then(response => {
                    const attendees = response.data.attendees;
                    const attendeesList = document.getElementById('attendeesList');
                    attendeesList.innerHTML = '';

                    attendees.forEach(attendee => {
                        const attendeeItem = document.createElement('li');
                        attendeeItem.className = 'list-group-item';
                        attendeeItem.innerHTML = `
                            <h5>${attendee.name}</h5>
                            <p>Email: ${attendee.email}</p>
                            <p>Event: ${attendee.event ? attendee.event.title : 'N/A'}</p>
                            <button class="btn btn-warning btn-sm mx-2" onclick="showEditForm(${attendee.id}, '${attendee.name}', '${attendee.email}', ${attendee.event_id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteAttendee(${attendee.id})">Delete</button>
                        `;
                        attendeesList.appendChild(attendeeItem);
                    });
                })
                .catch(error => console.error('Error fetching attendees:', error));
        }

        function fetchEvents() {
            axios.get('/api/events')
                .then(response => {
                    const events = response.data.events;
                    const addEventSelect = document.getElementById('addEvent');
                    const editEventSelect = document.getElementById('editEvent');

                    events.forEach(event => {
                        const option = document.createElement('option');
                        option.value = event.id;
                        option.textContent = event.title;
                        addEventSelect.appendChild(option);
                        editEventSelect.appendChild(option.cloneNode(true));
                    });
                })
                .catch(error => console.error('Error fetching events:', error));
        }

        document.getElementById('addAttendeeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const attendeeData = {
                name: this.name.value,
                email: this.email.value,
                event_id: this.event_id.value,
            };

            axios.post('/api/attendees', attendeeData)
                .then(response => {
                    alert('Attendee added successfully!');
                    this.reset();
                    fetchAttendees();
                })
                .catch(error => {
                    console.error('Error adding attendee:', error);
                    alert('Error adding attendee');
                });
        });

        function showEditForm(id, name, email, eventId) {
            document.getElementById('editAttendeeSection').style.display = 'block';
            document.getElementById('editAttendeeId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editEmail').value = email;
            document.getElementById('editEvent').value = eventId;
        }

        document.getElementById('editAttendeeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('editAttendeeId').value;
            const updatedData = {
                name: document.getElementById('editName').value,
                email: document.getElementById('editEmail').value,
                event_id: document.getElementById('editEvent').value,
            };

            axios.put(`/api/attendees/${id}`, updatedData)
                .then(response => {
                    alert('Attendee updated successfully!');
                    this.reset();
                    document.getElementById('editAttendeeSection').style.display = 'none';
                    fetchAttendees();
                })
                .catch(error => {
                    console.error('Error updating attendee:', error);
                    alert('Error updating attendee');
                });
        });


        function cancelEdit() {
            document.getElementById('editAttendeeSection').style.display = 'none';
            document.getElementById('editAttendeeForm').reset();
        }


        function deleteAttendee(id) {
            if (confirm('Are you sure you want to delete this attendee?')) {
                axios.delete(`/api/attendees/${id}`)
                    .then(response => {
                        alert('Attendee deleted successfully!');
                        fetchAttendees();
                    })
                    .catch(error => {
                        console.error('Error deleting attendee:', error);
                        alert('Error deleting attendee');
                    });
            }
        }

        // Load attendees and events on page load
        document.addEventListener('DOMContentLoaded', () => {
            fetchAttendees();
            fetchEvents();
        });
    </script>
</body>

</html>
