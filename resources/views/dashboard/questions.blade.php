<div class="content-margin-top">
	<div class="row">
		<div class="col-md-6">
    		<a id="questions/create" class="btn btn-primary redirect" href="#">Nova Questão</a>			
		</div>
		<div class="col-md-6">
    		<a id="upload" class="btn btn-primary text-white float-right" data-toggle="modal" data-target="#upload_modal">Importar Questões</a>			
			
		</div>
	</div>
	@php 
		$page = 10;
	@endphp
	@if(isset($id))
		<input type="hidden" name="query" value="topic_{{$id}}">
		<?php $questions = App\Models\Topic::find($id)->questions()->paginate($page); ?>
	@elseif(isset($search))
		<input type="hidden" name="query" value="search_{{$search}}">
		<?php $questions = App\Models\Question::search($search)->paginate($page); ?>
	@else
		<?php $questions = App\Models\Question::paginate($page); ?>
	@endif
		Questões: {{$questions->total()}}
	@if($questions->total() == 0)
	<div class="card card-main">
		<div class="card-body">
			Nenhuma questão encontrada.
    	</div>
	</div>
	@endif
	@if($questions->total() > $page)
		<div class="col-md-12">
			<div class="card py-2" style="width: auto; align-items: center">
				{{ $questions->links() }}					
			</div>
		</div>
	@endif
	@foreach($questions as $question)
    	@include('dashboard.question_card', ['question' => $question])
	@endforeach
	@if($questions->total() > $page)
		<div class="col-md-12">
			<div class="card py-2" style="width: auto; align-items: center">
				{{ $questions->links() }}					
			</div>
		</div>
	@endif
	<div class="modal fade" id="delete_question_modal" tabindex="-1" role="dialog" aria-labelledby="delete_question_modal" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="delete_question_modal">Apagar questão</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true"><i class="fa fa-remove"></i></span>
	        </button>
	      </div>
	      <div class="modal-body">
	      		<div class="row">
		      		<div class="col-md-10"></div>
		      		<div class="col-md-2">
			         		<img class='img-responsive' width="20px" height="20px" src="{{asset('img/dashboard/loading.gif')}}" alt="loading" id="loading-delete-question" style="display: none;">
					    </div>
					</div>
				</div>
	      <div class="modal-footer">
	      	<input type="hidden" name="question_id" value="">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
	        <button type="button" class="btn btn-danger delete-question">Apagar</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="upload_modal" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
      		<div class="modal-header">
		        <h5 class="modal-title" id="upload_modal">Importação de Questões (.txt)</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        		<span aria-hidden="true"><i class="fa fa-remove"></i></span>
		        </button>
	      	</div>
			<form id="import_form">
				<div class="modal-body">
					<div class="form-control">
						<div class="row">
						    {{ csrf_field() }}
						    <div class="col-md-10">
						    	<input type="file" name="file" accept="text/plain">
						    </div>
						    <div class="col-md-2">
				         		<img class='img-responsive' width="20px" height="20px" src="{{asset('img/dashboard/loading.gif')}}" alt="loading" id="loading-import" style="display: none;">
						    </div>
						</div>
					</div>
					<div class="form-group text-warning">
						<i class="fas fa-exclamation-triangle"></i> A importação pode demorar alguns minutos e será feita em background.
					</div>
				</div>
				<div class="modal-footer">
			      	<input type="hidden" name="question_id" value="">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
			        <button type="submit" id='submit-import' class="btn btn-primary">Enviar</button>
		    	</div>
			</form>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="response_modal" tabindex="-1" role="dialog" aria-labelledby="response_modal" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true"><i class="fa fa-remove"></i></span>
	        </button>
	      </div>
	      <div class="modal-body"></div>
	      <div class="modal-footer"></div>
	    </div>
	  </div>
	</div>
</div>

<script type="text/javascript">
	$('body').on('click','#delete_question', function (e) {
		e.preventDefault();
		var question = $(this).parent().parent().parent().find('div #question_identifier').children('u').text();
		var id = $(this).parent().find('input[name=question_id]').attr('data-id');
		$('#delete_question_modal').find('.modal-footer input[name=question_id]').val(id);
		$('#delete_question_modal').find('.modal-body .col-md-10').html("Deseja apagar a questão <b>" + question + "</b>?");
		$('#delete_question_modal').modal('toggle');
	});
</script>

