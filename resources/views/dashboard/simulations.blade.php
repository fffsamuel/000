@php
    $ip_sim = \Auth::user()
        ->doneSimulations()
        ->wherePivot('state','IN_PROGRESS')
        ->orderByDesc('updated_at')
        ->paginate(10);
    $dn_sim = \Auth::user()
        ->doneSimulations()
        ->wherePivot('state','COMPLETED')
        ->orderByDesc('updated_at')
        ->paginate(10);
@endphp
<!-- Nav tabs -->
<ul class="nav nav-tabs nav-tabs-main" style="border-bottom: 1px solid #ddd">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#inProgress-exams">Simulados em Progresso</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#done-exams">Simulados Concluídos</a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane" id="done-exams">
        @foreach( $dn_sim as $exam )
            @include('dashboard.exam_card', [
                'exam' => $exam,
                'exam_user_id' => $exam->pivot->id,
             ])
        @endforeach
        {{ $dn_sim->links()}}
    </div>
    <div class="tab-pane active" id="inProgress-exams">
        <div class="toolbar" style="margin-top: 10px">
            <a id="simulations/create" class="btn btn-primary redirect" href="#">Realizar novo simulado</a>
        </div>
        @foreach( $ip_sim as $exam )
            @include('dashboard.exam_card', [
                'exam' => $exam,
                'exam_user_id' => $exam->pivot->id,
             ])
        @endforeach
        {{ $ip_sim->links()}}
    </div>
</div>

