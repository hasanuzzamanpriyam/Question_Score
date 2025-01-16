<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Answers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <h1 class="text-center">View Answers</h1>
        @php
            $totalScore = 0;
        @endphp

        @foreach ($answers as $answer)
            @php
                $score = is_array($answer->answer_score) ? array_sum($answer->answer_score["score"]) : $answer->answer_score;
                $totalScore += $score;
            @endphp

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $answer->question->question_txt }}</h5>
                    <p>Selected Option: {{ $answer->answer_txt }}</p>
                    <p>Score: {{ $score }}</p>
                </div>
            </div>
        @endforeach
        <h2>Total Score: {{ $totalScore }}</h2>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
