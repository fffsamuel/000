@php
    $redirect = $exam->type_question == "EXAM" ? "exam" : "simulations"  . "/{$exam->id}";
    if( isset($exam_user_id) ){
        $redirect .= "/{$exam_user_id}";
    }
@endphp

<div class="card card-main">
    <div class="card-header">
        <div class="toolbar">
            <span class="badge badge-info">
                {{ $exam->questions()->count() }} questões
            </span>
            @if($exam->editableAndRemovable()) {{-- E se o professor é o dono da questão --}}
                <a href="#" onclick="redirect('exams/create?exam_id={{ $exam->id }}')">
                    <span class="fas fa-edit"></span>
                </a>
                <a href="#">
                    <span class="fa fa-remove"></span>
                </a>
            @endif
        </div>
        <a
            href="#"
            onclick="redirect('{{ $redirect  }}')">
            {{ $exam->title }}
        </a>

    </div>
    <div class="card-body">
        @if( isset($exam_user_id) )
            @include( 'dashboard/exam_state',[ 'exam_user_id' => $exam_user_id])
        @endif
    </div>
</div>