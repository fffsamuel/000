{{ $simulation->title  }}
<select name="num_questions">
    <option value="5">ver 5 questões</option>
    <option value="10">ver 10 questões</option>
    <option value="15">ver 15 questões</option>
    <option value="20">ver 20 questões</option>
</select>
@if( \App\Utils\Solution::getState($exam_user_id) == 'COMPLETED' )
    <span style="float:right;">
        @include( 'dashboard/exam_state',[ 'exam_user_id' => $exam_user_id])
    </span>
@endif

<div id="fields">
    <input type="hidden" id="simulation_id" value="{{ $simulation->id  }}">
    <input type="hidden" id="user_id" value="{{ Auth::user()->id  }}">
    <input type="hidden" id="exam_user_id" value="{{ $exam_user_id }}">
</div>

@php
    $questions =  $simulation->questions()->paginate(5);
    $page = $questions->currentPage();
    $total_page = $questions->lastPage();
@endphp
<button class="btn btn-primary btn-return-simulation mt-3">Sair</button>
<div id="current_question">
    @include('dashboard/solvable_question', [
        'index' => 0,
        'size' => $simulation->questions->count(),
        'question' => $questions,
        'exam_user_id' => $exam_user_id,
        'page' => $page,
        'total_page' => $total_page
    ])

</div>


<div class="modal fade" id="close_exam" tabindex="-1" role="dialog" aria-labelledby="close_exam" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="close_exam">Fechar Simulado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-remove"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="form-group">
                        <div class="row">
                            Suas respostas foram salvas com sucesso.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

