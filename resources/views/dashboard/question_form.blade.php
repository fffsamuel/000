{{-- {{dd($user_topics)}} --}}
<div class="content-margin-top">
    <form class="question-form">
        <input type="hidden" name="question_id" value="{{ $question->id }}">
        <input type="hidden" name="question_identifier" value="{{ $question->identifier }}">
        <div class="row col">
            <button class="btn btn-primary btn-return-question">Voltar</button>
        </div>
        <div class="row simple-row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Identificador</label>
                    <input type="text" name="identifier" class="form-control" value="{{ $question->identifier }}" required>
                </div>
            </div>
            <div class="col-md-9 form-group">
                <label class='verify_question'></label>
            </div>
        </div>
        <div class="row simple-row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Ano</label>
                    <input type="number" name="year" class="form-control" max="9999" min="0" value="{{ $question->year }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Banca</label>
                    <input type="text" name="board" class="form-control" value="{{ $question->board }}">
                </div>
            </div>
        
            <div class="col-md-3">
                <div class="form-group">
                    <label>Agência</label>
                    <input type="text" name="agency" class="form-control" value="{{ $question->agency }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Prova</label>
                    <input type="text" name="exam" class="form-control" value="{{ $question->exam }}">
                </div>
            </div>
        </div>
        @if(isset($topics))
        <div class="row simple-row">
            <div class="col">
                <label>Tópicos</label>
                    <select id='question_topics' class="custom-select">
                        <option value="0" selected>Escolha um tópico...</option>
                        @foreach($topics as $topic)
                            @if(isset($user_topics_array))
                                @if(in_array($topic->id, $user_topics_array))
                                    <option value="{{$topic->id}}" disabled="disabled" data-parent="{{$topic->parent_topic_id}}">{{$topic->description}}</option>
                                    }
                                @else
                                    <option value="{{$topic->id}}" data-parent="{{$topic->parent_topic_id}}">{{$topic->description}}</option>
                                @endif
                            @else
                                <option value="{{$topic->id}}" data-parent="{{$topic->parent_topic_id}}">{{$topic->description}}</option>
                            @endif
                        @endforeach
                    </select>
                    <div class="choosen_topics form-control">
                        @if(isset($user_topics))
                            @foreach($user_topics as $u_topic)
                                <div id="{{$u_topic->id}}" class="topic-question-text topics">
                                    <button class="btn-xs btn-danger topics_close" id=' + op.val() + '>
                                        <i class = "fa fa-close"></i>
                                    </button>
                                    <i class="fas fa-angle-right"></i>
                                    <span>{{$u_topic->description}}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{--<div class="form-group">--}}
            {{--<label for="wording">Tópicos</label>--}}
            {{--<select multiple data-role="tagsinput" name="topics">--}}
                {{--<option value="jQuery">jQuery</option>--}}
                {{--<option value="Angular">Angular</option>--}}
                {{--<option value="React">React</option>--}}
                {{--<option value="Vue">Vue</option>--}}
            {{--</select>--}}
        {{--</div>--}}

        <div class="form-group">
            <label for="wording">Enunciado</label>
            <textarea class="form-control summernote wording-input" id="question_wording" name="question_wording" placeholder="Digite o enunciado da questão">{{ $question->wording }}</textarea>
        </div>


        <div id="empty_answer" class="input-group mb-3 answer d-none">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="radio" id="right-one" name="right-one">
                </div>
            </div>
            <textarea class="form-control" name="answer_wording" placeholder= 'Resposta' rows="3"></textarea>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary remove-answer" type="button">
                    <span class="fa fa-times" aria-hidden="true"></span>
                </button>
            </div>
        </div>
        <div id="answers">
            @if($question->answers->count() <= 0)
                @foreach([1, 2] as $count)
                    <div class="input-group mb-3 answer">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input 
                                    type="radio" 
                                    id="right-one" 
                                    name="right-one"
                                    {{$count == 1 ? 'checked' : ''}}                                    
                                >
                            </div>
                        </div>
                        <textarea class="form-control" name="answer_wording" placeholder= 'Resposta' rows="3" required></textarea>               
                    </div>
                @endforeach
            @else
                @foreach( $question->answers as $answer )
                    <div class="input-group mb-3 answer">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input 
                                    type="radio" 
                                    id="right-one" 
                                    name="right-one"
                                    {{ $answer->correct ? 'checked' : '' }}
                                >
                            </div>
                        </div>
                        <textarea class="form-control" name="answer_wording" rows="3">{{ $answer->description }}</textarea>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary remove-answer" type="button">
                                <span class="fa fa-times" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <button type="button" class="btn btn-primary float-right add-answer">
            <span class="fa fa-plus" aria-hidden="true"></span>
        </button>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-2">
                <input type="submit" name="submit" id="send_question" class="btn btn-primary" value="salvar">
            </div>
            <div class="col-md-2 pt-1">
                <img class='img-responsive' width="40px" height="40px" src="{{asset('img/dashboard/loading.gif')}}" alt="loading" id="loading-create-question" style="display: none;">
            </div>
        </div>
    </form>
</div>
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">

<script src="{{ asset("js/redirect.js") }}"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
<script src="{{ asset('vendor/Bootstrap-4-Tag-Input-Plugin-jQuery/tagsinput.js') }}"></script>
{{-- <script src="{{ asset('js/dashboard.js') }}"></script> --}}
