@php
    $solution  = \App\Utils\Solution::getSolution($exam_user_id);
    $state  =  \App\Utils\Solution::getState($exam_user_id);
    $index = $questions->perPage()*($page-1) + 1;
@endphp



@foreach( $questions as $question )
    <input type="hidden" name="exam_state" value="{{$state}}">
    <div class="card card-solvable-question">
        <div class="header">
            <div class="row py-2">
                <div class="col-md-1">
                    <div class="round-number">
                        <label class="number-inside-round">{{ sprintf("%02d", $index++) }}</label>
                    </div>
                </div>
                <div class="col-md-2 transformY25">{!! $question->identifier !!}</div>
                <div class="col-md-9 topic-simulation-text">﻿
                    @foreach($question->topics as $topic)
                        @if($topic->parent_topic_id)
                            {{-- –  --}}
                            <i class="fas fa-angle-right"></i>
                        @else
                            <i class="fas fa-caret-right"></i>
                        @endif
                        {!! $topic->description !!}
                    @endforeach
                </div>

            </div>
            <div class="row">
                <div class="col-md-3"><b>Ano:</b> {!! $question->year !!}</div>
                <div class="col-md-3"><b>Banca:</b> {!! $question->board !!}</div>
                <div class="col-md-3"><b>Órgão:</b> {!! $question->agency !!}</div>
                <div class="col-md-3"><b>Prova:</b> {!! $question->exam !!}</div>
            </div>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">{!! $question->wording !!}</div>
            </div>
        </div>
        <div class="options">
            <ul>
                @foreach( $question->answers as $answer )
                    @php
                        $selected = array_key_exists($question->id, $solution) && $solution[$question->id] == $answer->id;
                        $highlight_class = '';
                        if( $state == 'COMPLETED' ){
                            if( $answer->correct ){
                                $highlight_class = 'highlight-correct';
                            }else if($selected){
                                $highlight_class = 'highlight-selected';
                            }
                        }
                    @endphp
                    <li class="{{ $highlight_class }}" >
                        <input
                            type="radio"
                            id="selected_answer_{{ $question->id  }}"
                            name="selected_answer_{{ $question->id }}"
                            class="select_answer" {{ $state == 'COMPLETED' ? 'disabled' : '' }}
                            data-exam_user_id="{{ $exam_user_id }}"
                            data-answer_id="{{ $answer->id }}"
                            data-question_id="{{ $question->id }}"
                            @if( $selected )
                                checked
                            @endif
                        >
                        {{ $answer->description  }}
                    </li>
                @endforeach
            </ul>
        </div>
        @if( $state == 'COMPLETED' )
            <div class="question-comments question-{{ $question->id }}">
                @include('dashboard.question_comments',compact('question'))
            </div>
        @endif

    </div>
@endforeach
<div class="simulation-progress">
    <button class="btn btn-primary display-question" data-page="{{ $page-1 }}" >Anterior</button>
    <span>{{ $page  }}/{{ $total_page }}</span>
    <button class="btn btn-primary display-question" data-page={{ $page+1 }}>Próxima</button>
</div>

@if( count($solution) == $questions->total() )
    <button class="btn btn-primary finish-simulation">Concluir</button>
@endif