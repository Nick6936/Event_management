<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">Category Management</h1>
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
                            <a class="nav-link active" href="{{ route('categories') }}">Categories</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <span class="navbar-text me-3">Welcome, {{ Auth::user()->name }}</span>
                        <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Add Category Form -->
        <div class="my-4">
            <h2>Add New Category</h2>
            <form id="addCategoryForm">
                <div class="mb-3">
                    <label for="addName" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="addName" name="name" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Category</button>
            </form>
        </div>

        <!-- Edit Category Form -->
        <div class="my-4" style="display: none;" id="editCategorySection">
            <h2>Edit Category</h2>
            <form id="editCategoryForm">
                <input type="hidden" id="editCategoryId">
                <div class="mb-3">
                    <label for="editName" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="editName" name="name" required>
                </div>
                <button type="submit" class="btn btn-success">Update Category</button>
                <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
            </form>
        </div>

        <!-- Display Categories -->
        <div class="my-4">
            <h2>Categories List</h2>
            <ul class="list-group" id="categoriesList"></ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function fetchCategories() {
            axios.get('/api/categories')
                .then(response => {
                    const categories = response.data.categories;
                    const categoriesList = document.getElementById('categoriesList');
                    categoriesList.innerHTML = ''; // list clear gareko
                    
                    categories.forEach(category => {
                        const categoryItem = document.createElement('li');
                        categoryItem.className = 'list-group-item';
                        categoryItem.innerHTML = `
                            <h5>${category.name}</h5>
                            <button class="btn btn-warning btn-sm mx-2" onclick="showEditForm(${category.id}, '${category.name}')">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteCategory(${category.id})">Delete</button>
                        `;
                        categoriesList.appendChild(categoryItem);
                    });
                })
                .catch(error => console.error('Error fetching categories:', error));
        }

        document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const categoryData = {
                name: this.name.value,
            };
            
            axios.post('/api/categories', categoryData)
                .then(response => {
                    alert('Category added successfully!');
                    this.reset();
                    fetchCategories();
                })
                .catch(error => {
                    console.error('Error adding category:', error);
                    alert('Error adding category');
                });
        });

        // edit form ma current data dekhauni
        function showEditForm(id, name) {
            document.getElementById('editCategorySection').style.display = 'block';
            document.getElementById('editCategoryId').value = id;
            document.getElementById('editName').value = name;
        }

        document.getElementById('editCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('editCategoryId').value;
            const updatedData = {
                name: document.getElementById('editName').value,
            };

            axios.put(`/api/categories/${id}`, updatedData)
                .then(response => {
                    alert('Category updated successfully!');
                    this.reset();
                    document.getElementById('editCategorySection').style.display = 'none';
                    fetchCategories();
                })
                .catch(error => {
                    console.error('Error updating category:', error);
                    alert('Error updating category');
                });
        });

        // editing cancel garda
        function cancelEdit() {
            document.getElementById('editCategorySection').style.display = 'none';
            document.getElementById('editCategoryForm').reset();
        }

        function deleteCategory(id) {
            if (confirm('Are you sure you want to delete this category?')) {
                axios.delete(`/api/categories/${id}`)
                    .then(response => {
                        alert('Category deleted successfully!');
                        fetchCategories();
                    })
                    .catch(error => {
                        console.error('Error deleting category:', error);
                        alert('Error deleting category');
                    });
            }
        }

        // page load huda categories load gareko
        document.addEventListener('DOMContentLoaded', fetchCategories);
    </script>
</body>
</html>
