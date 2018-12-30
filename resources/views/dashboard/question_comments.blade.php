<p>
    <a class="comment-section-toggle-btn" data-toggle="collapse" href="#comment-section-{{$question->id}}" role="button" aria-expanded="false" aria-controls="comment-section">
        <i class="fa fa-comment"></i><span id="number_comments">{{ $question->comments()->count() }}</span> comentários
    </a>
</p>
<div class="collapse" id="comment-section-{{$question->id}}">
    <div class="wrapper-comments">
        @foreach( $question->comments()->orderBy('created_at','asc')->get() as $comment)
            <div class="comment">
                <div class="h">{{ $comment->user->name }} disse:</div>
                <div class="b">{{ $comment->descripton }}</div>
                <div class="f">{{ $comment->data_formatada }}</div>
            </div>
        @endforeach
    </div>
    <div class="add-comment">
        <form class="form-add-comment" data-id="{{ $question->id }}">
            <input type="hidden" name="question_id" value="{{ $question->id }}">
            <div class="form-group">
                <textarea class="form-control" name="description" rows="3" placeholder="Deixe um comentário..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Enviar</button>
        </form>
    </div>
</div>

