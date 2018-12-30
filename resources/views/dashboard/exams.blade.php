<!-- Nav tabs -->
<ul class="nav nav-tabs nav-tabs-main" style="border-bottom: 1px solid #ddd">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#created-exams">Provas Criadas</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#done-exams">Banco de Provas</a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="created-exams">
        <div class="toolbar" style="margin-top: 10px">
            <a id="exams/create" class="btn btn-primary redirect" href="#">Criar Prova</a>
        </div>
        @foreach( \Auth::user()->createdExams as $exam )
            @include('dashboard.exam_card', ['exam' => $exam ])
        @endforeach
    </div>
    <div class="tab-pane fade" id="done-exams">
        @foreach( \App\Models\Exam::where('question_type','EXAM')->get() as $exam )
            @include('dashboard.exam_card', ['exam' => $exam ])
        @endforeach
    </div>
</div>

