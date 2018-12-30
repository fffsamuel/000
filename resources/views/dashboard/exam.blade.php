{{ $exam->title  }}
@foreach( $exam->questions as $question )
    @include('dashboard.question_card')
@endforeach