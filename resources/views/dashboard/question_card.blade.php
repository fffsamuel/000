<div class="card card-main">
    <div class="card-header">
        <div class="toolbar">
            <input type="hidden" name="question_id" data-id="{{$question->id}}"/>
            <a href="#" onclick="redirect('questions/create?question_id={{ $question->id }}')">
                <span class="fas fa-edit"></span>
            </a>
            {{-- <a href="#" data-toggle="modal" data-target="#delete_question_modal"> --}}
            <a href="#" id="delete_question">
                <span class="fas fa-trash-alt"></span>
            </a>
        </div>
        <div id="question_identifier" data-identifier="{!! $question->identifier !!}" class="color-orange"><u>{!! $question->identifier !!}</u></div>
        <div class="row">
            <div class="col-md-3"><b>Ano:</b> {{$question->year}}</div>
            <div class="col-md-3"><b>Banca:</b> {{$question->board}}</div>
            <div class="col-md-3"><b>Órgão:</b> {{$question->agency}}</div>
            <div class="col-md-3"><b>Prova:</b> {{$question->exam}}</div>
        </div>
    @if($question->topics->count() > 0)
        <div class="choosen_topics topic-question-text">
            @foreach($question->topics as $u_topic)
                @if($u_topic->parent_topic_id)
                    <i class="fas fa-angle-right"></i>
                @else
                    <i class="fas fa-caret-right"></i>
                @endif
                <a id={{$u_topic->id}} class="topic-link" data-id = "{{$u_topic->id}}" data-description="{{$u_topic->description}}">
                    {{$u_topic->description}} 
                </a>
            @endforeach
        </div>
    @endif
        {{-- <hr> --}}

        <div class="pt-3"> {!! $question->wording !!}</div>
    </div>
    <div class="card-body">
        <ol type="a">
            @foreach($question->answers as $answer)
                <li>
                    {{ $answer->description }} 
                    @if( $answer->correct )
                        <span class="color-orange fa fa-check"></span> 
                    @endif
                </li>
            @endforeach
        </ol>
        <div class="question-comments question-{{ $question->id }}">
            @include('dashboard.question_comments',compact('question'))
        </div>
    </div>
</div>