@foreach( $exam->questions as $question )
    @php
        $contains = $exam->questions->contains($question);
    @endphp
    <div class="question-picker question-{{ $question->id }}" >
        <div class="left">
            @include('dashboard.question_card')
        </div>
        <div class="right">
            <button
                    class="btn btn-primary btn-sm attach-question"
                    data-question_id="{{ $question->id }}"
                    data-exam_id="{{ $exam->id }}"
                    style="display: {{ $contains ? 'none' : 'block'  }}">
                <i class="fa fa-plus"></i>Adicionar
            </button>
            <button
                    class="btn btn-danger btn-sm detach-question"
                    data-question_id="{{ $question->id }}"
                    data-exam_id="{{ $exam->id }}"
                    style="display: {{ !$contains ? 'none' : 'block'  }}">
                <i class="fa fa-remove"></i>Remover
            </button>
        </div>
    </div>
@endforeach