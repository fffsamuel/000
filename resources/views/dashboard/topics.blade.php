<div class="container-fluid">
    <p>
        <button type="button" id="root_topic" class="btn btn-primary">Inserir tópico raiz</button>
    </p>
    <div id="tree">
        <div class="row">
            <div class="col-md-12" style="text-align: -webkit-center;">
                <img class="img-responsive" src="{{asset('img/dashboard/loading.gif')}}" alt="loading" id="loading-page" style="display: block; width: 50px; height: 50px;">
            </div>
        </div>
    </div>        
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="topic_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inserir tópico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-remove"></i></span>
                </button>
            </div>
            <form id="topic_form">
                <input type="hidden" name="topic_id" value="">
                <input type="hidden" name="parent_topic_id" value="">
                <div class="modal-body">
                        <div class="form-group" id="parent_topic_section">
                            Sub-tópico de <strong><span class="color-orange" id="sub_topic_description"></span></strong>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                        <div class="row py-2">
                            <div class="col">
                                <label>Descrição</label>
                                <input type="text" class="form-control" name="description">
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col">
                                <label>Url</label>
                                <input type="text" class="form-control" name="url">  <a href='#' class="url fas fa-eraser"></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-0">Vídeos suportados:</div>
                            <div class="col-md-1 px-2">
                                <a href="https://www.youtube.com/" target="_blank" class="fa-2x fab fa-youtube"></a>
                            </div>
                            <div class="col-md-1 px-2">
                                <a href="https://vimeo.com" target="_blank" class="fa-2x fab fa-vimeo"></a>
                            </div>
                        </div>
                    </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                    <button type="submit" class="btn btn-primary">Criar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="edit_topic_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edite o tópico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-remove"></i></span>
                </button>
            </div>
            <form id="edit_topic_form">
                <input type="hidden" name="topic_id" value="">
                <input type="hidden" name="parent_topic_id" value="">
                <div class="modal-body">                        
                    <div class="form-group">
                        <div class="row py-2">
                            <div class="col">
                                <label>Descrição</label>
                                <input type="text" class="form-control" name="description">
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col">
                                <label>Url</label>
                                <input type="text" class="form-control" name="url"> <a href='#' class="url fas fa-eraser"></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-0">Vídeos suportados:</div>
                            <div class="col-md-1 px-2">
                                <a href="https://www.youtube.com/" target="_blank" class="fa-2x fab fa-youtube"></a>
                            </div>
                            <div class="col-md-1 px-2">
                                <a href="https://vimeo.com" target="_blank" class="fa-2x fab fa-vimeo"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="delete_topic_modal" tabindex="-1" role="dialog" aria-labelledby="delete_topic_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete_topic_modal">Apagar tópico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-remove"></i></span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                    <img class='img-responsive' width="20px" height="20px" src="{{asset('img/dashboard/loading.gif')}}" alt="loading" id="loading-delete-topic" style="display: none;">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="topic_id" value="">
                        <input type="hidden" name="parent_topic_id" value="">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                        <button type="button" class="btn btn-danger delete-topic">Apagar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exchange_topic_modal" tabindex="-1" role="dialog" aria-labelledby="exchange_topic_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exchange_topic_modal">Alterar tópico pai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-remove"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="exchange_topic_form">
                <div class="row">
                    <div class="col">Escolha um novo tópico para mover este:</div>
                </div>
                <div class="row">
                    <div class="col">
                    <input type="hidden" name="topic_id">
                    <input type="hidden" name="parent_topic_id">
                        <select id='select_topics' class="custom-select">
                            <option value="0" selected>Escolha um tópico...</option>
                            @foreach($topics as $topic)
                                <option value="{{$topic->id}}" data-parent="{{$topic->parent_topic_id}}">{{$topic->description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
            </div>
            <div class="modal-footer">
                    <img class='img-responsive' width="20px" height="20px" src="{{asset('img/dashboard/loading.gif')}}" alt="loading" id="loading-exchange-topic" style="display: none;">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                        <button type="button" class="btn btn-primary exchange-topic">Alterar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var tree, parent;
        function initTopicTree(){
            tree = $('#tree').tree({
                uiLibrary: 'bootstrap4',
                dataSource: APP_URL + '/dashboard/topics/tree',
                primaryKey: 'id',
                initialized: function (e) {
                    setTimeout(function(){
                        $(".js-modal-btn").modalVideo();
                    }, 1000);
                }
            });
        }

        initTopicTree();
        
        function returnTopic(topic){
            url_id = topic.url;
            video = '';
            if(topic.url != null){
                if(topic.url.indexOf('watch?v=') != -1){
                    url_id = topic.url.split("watch?v=")[1];
                    video = '<a href="#" id="video_topic" class="js-modal-btn" data-video-id="' + url_id + '">'+
                        '<span class="fab fa-youtube "></span>'+
                    '</a>';
                }
                if(topic.url.indexOf('vimeo') != -1){
                    url_div = topic.url.split("/");
                    url_id = url_div.pop();
                    video = '<a href="#" id="video_topic" class="js-modal-btn" data-channel="vimeo" data-video-id="' + url_id + '">'+
                                '<span class="fab fa-vimeo"></span>'+
                            '</a>';
                }
            }
            return '<div class="card card-topic">'+
                '<div class="row">'+
                    '<div class="topic-number round-number ">'+
                        '<label class="number-inside-round">00</label>'+
                    '</div>'+
                    '<div class="col col-md-6 col-xl-8 topic-text">'+
                        '<div class="color-orange">'+
                            '<a href="#" class="topic-link" data-id = ' + topic.id + ' data-description= ' + topic.description + '>' + topic.description +
                            ' (0)</a>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col col-md-6 col-xl-4 text-right">'+
                        '<a class="topic-tree-node" data-id="" data-id_parent_topic="' + topic.id + '" data-description="' + topic.description + '">'+
                            '<i class="fa fa-plus"></i>'+
                        '</a>'+
                        '<a href="#" class="edit_topic" data-id="' + topic.id + '" data-id_parent_topic="' + topic.id_parent_topic + '" data-description="' + topic.description + '" data-url="' + topic.url + '">' +
                            '<span class="fas fa-edit"></span>'+
                        '</a>'+ video
                        +
                        '<a href="#" id="delete_topic" data-id="' + topic.id + '" data-id_parent_topic="' + topic.id_parent_topic + '" data-description="' + topic.description + '"data-children-count="0" data-question-count="0">'+
                            '<span class="fa fa-trash-alt"></span>'+
                        '</a>'+
                    '</div>'+
                '</div>';
        }

        function appendTopic(topic) {
            tree.addNode({'id': topic.id, text: returnTopic(topic), 'hasChildren': true}, (parent != '' ? parent : null));
        }

        $('body').on('click','.topic-tree-node', function (e) {
            $('#parent_topic_section').show();
            $('#topic_form input[name=topic_id]').val($(this).data('id'));
            $('#topic_form input[name=parent_topic_id]').val($(this).data('id_parent_topic'));
            $('#topic_modal #sub_topic_description').html($(this).data('description'));
            $('#topic_modal').modal();
        });

        $('body').on('click','.edit_topic', function (e) {
            $('#parent_topic_section').hide();
            $('#edit_topic_form input[name=topic_id]').val($(this).data('id'));
            $('#edit_topic_form input[name=parent_topic_id]').val($(this).data('id_parent_topic'));
            $('#edit_topic_form input[name=description]').val(($(this).data('description')));
            $('#edit_topic_form input[name=url]').val(($(this).data('url')));
            $('#edit_topic_modal').modal();
        });

        $('body').on('click','#root_topic', function (e) {
            $('#parent_topic_section').hide();
            $('#topic_form input[name=topic_id]').val("");
            $('#topic_form input[name=parent_topic_id]').val("");
            $('#topic_modal #sub_topic_description').html( "nada" );
            $('#topic_modal').modal();
        });

        $('#topic_form').on('submit', function (e) {
            e.preventDefault();
            url = $(this).serialize().split('url=')[1];
            if(url != ''){
                if(url.indexOf('watch') == -1 && url.indexOf('vimeo') == -1){
                    alert("Formato de vídeo não suportado.");
                    return;
                }
            }
            axios.post( APP_URL + '/dashboard/topics', $(this).serialize()).then(function (response) {
                parent = tree.getNodeById(response.data.parent_topic_id);
                appendTopic(response.data);
                if(parent != null){
                    tree.expand(parent);
                }
                console.log(response);
                $('#topic_modal').modal('hide');
                $('#topic_form').trigger('reset');
                setTimeout(function(){
                    $('body li').find('[data-id="'+ response.data.id +'"]').parent().find('#video_topic').modalVideo();
                }, 1000);
            });
        });

        $('#edit_topic_form').on('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();
            url = $(this).serialize().split('url=')[1];
            if(url != ''){
                if(url.indexOf('watch') == -1 && url.indexOf('vimeo') == -1){
                    alert("Formato de vídeo não suportado.");
                    return;
                }
            }
            axios.post( APP_URL + '/dashboard/topics', $(this).serialize())
            .then(function (response) {
                parent = tree.getNodeById(response.data.id);
                parent.text = returnTopic(response.data);
                tree.updateNode(response.data.id, parent);
                $('#edit_topic_modal').modal('hide');
                $('#edit_topic_form').trigger('reset');
                setTimeout(function(){
                    $('body li').find('[data-id="'+ response.data.id +'"]').parent().find('#video_topic').modalVideo();
                }, 1000);
            })
            .catch(function(response) {
                console.log(response);
            });
        });

        $( 'body' ).on( 'click','.delete-topic', function (e){
            $('#loading-delete-topic').show();
            $(this).parent().find('button').prop('disabled', true);
            var data = {'id': $(this).parent().find('input[name=topic_id]').val()};
            var parent_topic_id = {'id': $(this).parent().find('input[name=parent_topic_id]').val()};
            axios
                .post(APP_URL+'/dashboard/topics/delete', data)
                .then(function(response) {
                    $('#loading-delete-topic').hide();
                    $('#delete_topic_modal').modal('toggle');
                    var node = tree.getNodeById(response.data.id);
                    $('#delete_topic_modal').find('button').prop('disabled', false);
                    tree.removeNode(node);
                    console.log(response);
                })
                .catch(function(response) {
                    console.log(response);
                    $('#delete_topic_modal').find('button').prop('disabled', false);
                });
        });

        $( 'body' ).on( 'click','.exchange-topic', function (e){
            $('#loading-exchange-topic').show();
            $(this).parent().find('button').prop('disabled', true);
            var id = $('#exchange_topic_form').find('input[name=topic_id]').val();
            var parent_topic_id = $('#select_topics').find(':selected').val();
            var data = {'id': id, 'parent_topic_id' : parent_topic_id};
            axios
                .post(APP_URL+'/dashboard/topics/exchange', data)
                .then(function(response) {
                    $('#loading-exchange-topic').hide();
                    $('#exchange_topic_modal').find('button').prop('disabled', false);
                    $('#exchange_topic_modal').modal('toggle');
                    console.log(response);
                    setTimeout(function(){
                        // tree.reload();
                        redirect('topics');
                    }, 200);
                })
                .catch(function(response) {
                    console.log(response);
                    $('#loading-exchange-topic').hide();
                    $('#exchange_topic_modal').find('button').prop('disabled', false);
                });
        });

        $('body').on('click','#delete_topic', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var topic = $(this).data('description');
            var children_count = $(this).data('children-count');
            var question_count = $(this).data('question-count');
            $('#delete_topic_modal').find('.modal-footer input[name=parent_topic_id]').val($(this).data('id_parent_topic'));
            $('#delete_topic_modal').find('.modal-footer input[name=topic_id]').val(id);
            $('#delete_topic_modal').find('.modal-body').html("Deseja apagar o tópico <b>" + topic + "</b>?");
            if(children_count + question_count > 0){
                $('#delete_topic_modal').find('.modal-body').append("<br><br><span class='text-danger'><div class='row'><div class='col-md-2'><i class='fas fa-exclamation-circle'></i></div><div class='col-md-10'></div></div></span>");
                if(children_count > 0){
                    $('#delete_topic_modal').find('.modal-body .col-md-10').append("<p>Se este tópico for apagado, " + ((children_count == 1) ? "<b>" + children_count + "</b> tópico associado a este também será." : "os outros <b>" +  children_count  + "</b> tópicos associados a este também serão.</p>"));
                }
                if(question_count > 0){
                    $('#delete_topic_modal').find('.modal-body .col-md-10').append("<p>Este tópico está associado a <b>" + question_count + "</b> " + ((question_count == 1) ? "questão." : "questões.</p>"));
                }
                $('#delete_topic_modal').find('.modal-body').append("<br><p class='text-danger'><b>Você realmente deseja apagar este tópico?</b></p>");
            }

            $('#delete_topic_modal').modal('toggle');
        });

    });
</script>


