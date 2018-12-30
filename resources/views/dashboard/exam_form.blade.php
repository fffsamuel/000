<div class="content-margin-top">
    <form class="exam-form">
        <input type="hidden" name="question_id" value="{{ $exam->id }}">
        <div class="form-group">
            <input
                type="text"
                class="form-control"
                id="title"
                name="title"
                placeholder="Digite o título da prova"
                value="{{ $exam->title }}" >
        </div>
    </form>
    @if( $exam->id )

        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab1">Banco de Questões</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab2">Questões Adicionadas <span id="add_questions_length"></span></a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane container active" id="tab1">
                <div id="questions_add_section">
                    <div class="form-group">
                        <label>Pesquisar</label>
                        <form id="search_question">
                            <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                            <input type="text" class="form-control" name="search">
                        </form>
                    </div>
                    <div id="questions">
                        @include( 'dashboard.question_picker')
                    </div>
                </div>
            </div>
            <div class="tab-pane container fade" id="tab2">
                <div id="questions_added_section">
                    <div id="questions">
                        @include( 'dashboard.question_added', [ 'exam' => $exam ])
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>