<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
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
        <h1 class="text-center">Event Management</h1>
        <!-- Add Event Form -->
        <div class="my-4">
            <h2>Add New Event</h2>
            <form id="addEventForm">
                <div class="mb-3">
                    <label for="addTitle" class="form-label">Event Title</label>
                    <input type="text" class="form-control" id="addTitle" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="addDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="addDescription" name="description" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="addDate" class="form-label">Date</label>
                    <input type="date" class="form-control" id="addDate" name="date" required>
                </div>
                <div class="mb-3">
                    <label for="addLocation" class="form-label">Location</label>
                    <input type="text" class="form-control" id="addLocation" name="location" required>
                </div>
                <div class="mb-3">
                    <label for="addCategory" class="form-label">Category</label>
                    <select class="form-select" id="addCategory" name="category_id" required>
                        <option value="" disabled selected>Select a category</option>
                        <!-- Categories will be populated here -->
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Add Event</button>
            </form>
        </div>

        <!-- Edit Event Form -->
        <div class="my-4" style="display: none;" id="editEventSection">
            <h2>Edit Event</h2>
            <form id="editEventForm">
                <input type="hidden" id="editEventId">
                <div class="mb-3">
                    <label for="editTitle" class="form-label">Event Title</label>
                    <input type="text" class="form-control" id="editTitle" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="editDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="editDescription" name="description" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="editDate" class="form-label">Date</label>
                    <input type="date" class="form-control" id="editDate" name="date" required>
                </div>
                <div class="mb-3">
                    <label for="editLocation" class="form-label">Location</label>
                    <input type="text" class="form-control" id="editLocation" name="location" required>
                </div>
                <div class="mb-3">
                    <label for="editCategory" class="form-label">Category</label>
                    <select class="form-select" id="editCategory" name="category_id" required>
                        <option value="" disabled>Select a category</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Update Event</button>
                <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
            </form>
        </div>

        <!-- Display Events -->
        <div class="my-4">
            <h2>Events List</h2>
            <ul class="list-group" id="eventsList"></ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function fetchCategories() {
            axios.get('/api/categories')
                .then(response => {
                    const categories = response.data.categories; 
                    const addCategorySelect = document.getElementById('addCategory');
                    const editCategorySelect = document.getElementById('editCategory');


                    addCategorySelect.innerHTML = '<option value="" disabled selected>Select a category</option>';
                    editCategorySelect.innerHTML = '<option value="" disabled selected>Select a category</option>';

                    categories.forEach(category => {
                        const option = new Option(category.name, category.id);
                        addCategorySelect.add(option);
                        editCategorySelect.add(option.cloneNode(true)); 
                    });
                })
                .catch(error => console.error('Error fetching categories:', error));
        }

        function fetchEvents() {
            axios.get('/api/events')
                .then(response => {
                    const events = response.data.events; 
                    console.log('Fetched Events:', events);
                    const eventsList = document.getElementById('eventsList');
                    eventsList.innerHTML = ''; 
                    
                    if (events && events.length > 0) {
                        events.forEach(event => {
                            const eventItem = document.createElement('li');
                            eventItem.className = 'list-group-item';
                            eventItem.innerHTML = `
                                <h5>${event.title}</h5>
                                <p>${event.description}</p>
                                <small>Date: ${event.date} | Location: ${event.location} | Category: ${event.category.name}</small> <!-- Access category name -->
                                <button class="btn btn-warning btn-sm mx-2" onclick="showEditForm(${event.id}, '${event.title}', '${event.description}', '${event.date}', '${event.location}', ${event.category_id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteEvent(${event.id})">Delete</button>
                            `;
                            eventsList.appendChild(eventItem);
                        });
                    } else {
                        eventsList.innerHTML = '<li class="list-group-item">No events available.</li>';
                    }
                })
                .catch(error => console.error('Error fetching events:', error));
        }

        document.getElementById('addEventForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const eventData = {
                title: this.title.value,
                description: this.description.value,
                date: this.date.value,
                location: this.location.value,
                category_id: this.category_id.value 
            };
            
            axios.post('/api/events', eventData)
                .then(response => {
                    alert('Event added successfully!');
                    this.reset();
                    fetchEvents();
                })
                .catch(error => {
                    console.error('Error adding event:', error);
                    alert('Error adding event');
                });
        });

        function showEditForm(id, title, description, date, location, categoryId) {
            document.getElementById('editEventSection').style.display = 'block';
            document.getElementById('editEventId').value = id;
            document.getElementById('editTitle').value = title;
            document.getElementById('editDescription').value = description;
            document.getElementById('editDate').value = date;
            document.getElementById('editLocation').value = location;
            document.getElementById('editCategory').value = categoryId;
            
            //form hide garna
            document.getElementById('addEventForm').reset();
        }


        function cancelEdit() {
            document.getElementById('editEventSection').style.display = 'none';
        }


        document.getElementById('editEventForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const eventId = this.editEventId.value;
            const eventData = {
                title: this.title.value,
                description: this.description.value,
                date: this.date.value,
                location: this.location.value,
                category_id: this.category_id.value 
            };
            
            axios.put(`/api/events/${eventId}`, eventData)
                .then(response => {
                    alert('Event updated successfully!');
                    fetchEvents();
                    cancelEdit();
                })
                .catch(error => {
                    console.error('Error updating event:', error);
                    alert('Error updating event');
                });
        });

        function deleteEvent(id) {
            if (confirm('Are you sure you want to delete this event?')) {
                axios.delete(`/api/events/${id}`)
                    .then(response => {
                        alert('Event deleted successfully!');
                        fetchEvents();
                    })
                    .catch(error => {
                        console.error('Error deleting event:', error);
                        alert('Error deleting event');
                    });
            }
        }

        fetchCategories();
        fetchEvents();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
