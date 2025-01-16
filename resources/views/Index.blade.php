<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ask a Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="text-center">Create a Question</h1>
                        <form class="form-group" action="{{ route('questions.store') }}" method="POST">
                            @csrf

                            {{ $errors }}
                            <div class="mb-3">
                                <select name="category_id" id="categorySelect" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->panel_type }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addCategoryModal">+</button>
                            </div>

                            <textarea name="question" class="form-control mb-3" placeholder="Type your question here..." rows="5" required></textarea>
                            <div class="options-section mb-3">
                                <h6 class="mb-2">Options:</h6>
                                <div id="dynamicFields">
                                    <div class="input-group mb-2">
                                        <input type="text" name="options[]" class="form-control" placeholder="Option"
                                            required>
                                        <input type="number" name="score[]" class="form-control" placeholder="Score"
                                            required>
                                        <button type="button" class="btn btn-primary addField"
                                            onclick="addNewField()">+</button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Submit Question</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body">
                    <form id="addCategoryForm">
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="panel_type" class="form-label">Panel Type</label>
                            <input type="text" class="form-control" id="panel_type" name="panel_type" required>
                        </div>
                        <input type="hidden" name="created_by">
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script>
    function addNewField() {
        var newField = document.createElement('div');
        newField.className = 'input-group mb-2';
        newField.innerHTML = `
        <input type="text" name="options[]" class="form-control" placeholder="Option">
        <input type="text" name="score[]" class="form-control" placeholder="Score">
        <button type="button" class="btn btn-primary addField">+</button>
        <button type="button" class="btn btn-danger remove-field">-</button>
        `;

        document.getElementById('dynamicFields').appendChild(newField);

        newField.querySelector('.addField').addEventListener('click', addNewField);
        newField.querySelector('.remove-field').addEventListener('click', function() {
            newField.remove();
        });
    }


    $('#addCategoryForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '/categories',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#categorySelect').append('<option value="' + response.newCategory.category_name +
                    '">' +
                    response.newCategory.panel_type + '</option>');
                $('#addCategoryModal').modal('hide');
                $('#addCategoryForm')[0].reset(); // Reset the form fields
            },
            error: function(xhr) {
                alert('An error occurred while adding the category.');
            }
        });
    });
</script>

</html>
