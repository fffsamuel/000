<form id="simulation_form">
    <input type="hidden" id="simulation_create_mode" name="simulation_create_mode" value="T">
    <div class="form-group flexbox" style="flex-direction: column">
        <label>
            quantidade de questões
        </label>
        <input type="number" class="form-control" name="number_questions" placeholder="25">
    </div>
    <hr>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs flexbox nav-opt-sim">
        <li class="nav-item">
            <a class="nav-link active" data-simulation_create_mode="T" data-toggle="tab" href="#tab1">Filtrar por tópico</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-simulation_create_mode="O" data-toggle="tab" href="#tab2">Filtrar por orgão</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-simulation_create_mode="B" data-toggle="tab" href="#tab3">Filtrar por banca</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-simulation_create_mode="P" data-toggle="tab" href="#tab4">Filtrar por prova</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane container active" id="tab1">
            <div class="form-group">
                <select id='question_topics' class="custom-select">
                    <option value="0" selected>Escolha um tópico...</option>
                    @foreach( \App\Models\Topic::all() as $topic)
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
                <div class="choosen_topics form-control" style="background-image: none"></div>
                <hr>
            </div>
        </div>
        <div class="tab-pane container fade" id="tab2">
            <div class="form-group">
                <select id='agency' class="custom-select">
                    <option value="0" selected>Escolha um orgão...</option>
                    @foreach( \App\Models\Question::unique('agency') as $unique)
                        <option value="{{ $unique  }}">{{ $unique }}</option>
                    @endforeach
                </select>
                <hr>
            </div>
        </div>
        <div class="tab-pane container fade" id="tab3">
            <div class="form-group">
                <select id='board' class="custom-select">
                    <option value="0" selected>Escolha uma banca...</option>
                    @foreach( \App\Models\Question::unique('board') as $unique)
                        <option value="{{ $unique  }}">{{ $unique }}</option>
                    @endforeach
                </select>
                <hr>
            </div>
        </div>
        <div class="tab-pane container fade" id="tab4">
            <div class="form-group">
                <select id='exam' class="custom-select">
                    <option value="0" selected>Escolha uma prova...</option>
                    @foreach( \App\Models\Question::unique('exam') as $unique)
                        <option value="{{ $unique  }}">{{ $unique }}</option>
                    @endforeach
                </select>
                <hr>
            </div>
        </div>
    </div>
    <div class="flexbox">
        <input type="submit" class="btn btn-primary btn-jumbo" value="Gerar simulado">
    </div>
</form>