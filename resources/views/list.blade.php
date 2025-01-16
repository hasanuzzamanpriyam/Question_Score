<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions and Options</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <h1 class="text-center">Questions</h1>
        <form action="{{ route('store_answers') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{ $errors }}
            @foreach ($questions as $question)
                <div class="card mb-4" id="question{{ $question->id }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $question->question_txt }}</h5>
                        <div class="form-group">
                            <select class="form-select" name="answer[{{ $question->id }}][option]" onchange="updateScore(this, 'score{{ $question->id }}', {{ $question->id }})">
                                <option value="" data-score="0">Select an option</option>
                                @foreach (explode(', ', $question->question_type) as $index => $option)
                                    <option value="{{ $option }}"
                                        data-score="{{ $question->score[$index]->score ?? 0 }}">{{ $option }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="answer[{{ $question->id }}][score]" id="hiddenScore{{ $question->id }}">
                        </div>
                        <p class="mt-2 text-muted d-none" id="score{{ $question->id }}" class="mt-2 text-muted"></p>
                    </div>
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Submit Answers</button>
        </form>
    </div>

    <script>
        function updateScore(select, scoreElementId, questionId) {
            const selectedOption = select.options[select.selectedIndex];
            const score = selectedOption.getAttribute('data-score');
            document.getElementById(scoreElementId).innerText = `Score: ${score}`;
            document.getElementById('hiddenScore' + questionId).value = score;
        }



        document.querySelector('form').addEventListener('submit', function(event) {
    let valid = true;

    // Show the score paragraphs only if the form is valid
    document.querySelectorAll('select[name^="answer"]').forEach(function(select) {
        if (select.value === '') {
            valid = false;
        }
    });

    if (!valid) {
        event.preventDefault();
        alert('Please select an option for each question.');
    } else {
        document.querySelectorAll('.text-muted').forEach(function(p) {
            p.classList.add('d-none');
        });
    }
});
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
