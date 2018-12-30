APP_URL = window.location.protocol + '//' + window.location.host;
last_page = '';

function startSummernote(){
    $('.summernote').summernote({
        height: 220,
        toolbar: [
            ['font', ['fontname', 'fontsize', 'bold', 'italic','underline','color','clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert',['picture','table','hr']]
        ],
        callbacks: {
            onImageUpload: function(files) {
                // upload image to server and create imgNode...
                // $summernote.summernote('insertNode', imgNode);
                var data = new FormData();
                data.append('image', files[0]);
                axios.post( APP_URL + '/dashboard/images', data ).then(function (response) {
                    console.log(response.data);
                    // var imgNode = $('<img>').attr('src', APP_URL + '/dashboard/images/' + response.data);
                    var imgNode = document.createElement('img');
                    imgNode.src = APP_URL + '/dashboard/images/' + response.data;
                    console.log( imgNode );
                    // $summernote.summernote('insertNode', imgNode);
                    $('.summernote').summernote('insertNode', imgNode);
                }).catch( function (error) {
                    console.log(error);
                });
            }
        }
    });
}
function addAnswer() {
    var empty_answer = $('#empty_answer').clone();
    empty_answer.attr('id', '');
    empty_answer.appendTo($('#answers'));
    empty_answer.removeClass('d-none');
}
function loadStart(page) {
  $('#loading-' + page).show();
}
function loadStop(page) {
  $('#loading-' + page).hide();
}
function redirect(page){
    if(page.indexOf('create') == -1){
        last_page = page;
    }
    $.ajax({
        type: "GET",
        url: "/dashboard/" + page,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    })
    .done(function(html){
        if(parseInt(html) != 0){
            $('#dashboard-content').empty().append(html);
            startSummernote();
        }
    });
    return false;
}

$(document).ready(function(){
    $.ajax({
        type: "GET",
        url: "/dashboard/home",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend:function(html){
            $('#dashboard-content').empty().append('<div class="row"><div class="col-md-12" style="text-align: -webkit-center;"><img class="img-responsive" src="/img/dashboard/loading.gif" alt="loading" id="loading-page" style="display: block; width: 50px; height: 50px;"></div></div>');
        }
    })
    .done(function(html){
        if(parseInt(html) != 0){
            $('#dashboard-content').empty().append(html);
        }
    });

    $( 'body' ).on( 'click','.dashboard-menu', function (e){
        e.preventDefault();
        e.stopPropagation();
        $("li").removeClass('active');
        page = $(this).attr('id');
        if(page == "user")
            $('#user-menu').addClass('active');
        else
            $('#'+page).parent('li').addClass('active');
        if(page.indexOf('create') == -1){
            last_page = page;
        }
        $.ajax({
            type: "GET",
            url: "/dashboard/" + page,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: loadStart(page),
            complete: loadStop(page)
        })
        .done(function(html){
            if(parseInt(html) != 0){
                $('#dashboard-content').empty().append(html);
            }
        });
        e.stopImmediatePropagation();
        return false;
    });

    $( 'body' ).on( 'click','#dashboard-home', function (e){
        e.preventDefault();
        e.stopPropagation();
        $.ajax({
            type: "GET",
            url: "/dashboard/home",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },            
        })
        .done(function(html){
            if(parseInt(html) != 0){
                $("li").removeClass('active');
                $('#dashboard-content').empty().append(html);
            }
        });
        e.stopImmediatePropagation();
        return false;
    });

    $('body').on('click','.redirect',function (e){
        redirect($(this).attr('id'));
        return false;
    });

    $('body').on('click','.avatar-upload',function(e){
        $('#avatar_upload').trigger('click');
    });

    startSummernote();

    // função para adicionar resposta no formulario
    $('body').on('click','.add-answer',addAnswer);

    function questionOptionRecursive(op){
        if(op.attr('data-parent') != ""){
            questionOptionRecursive($(op).closest('select').find('option[value=' + op.attr('data-parent') + ']'));
        }
        if(!op.attr('disabled')){
            $('div.choosen_topics').append('<div id=' + op.val() + ' class="topic-question-text topics"><button class="btn-xs btn-danger topics_close" id=' + op.val() + '><i class = "fa fa-close"></i></button> <i class="fas fa-angle-right"></i> <span>' + op.text() + '</span></div>');
            op.attr('disabled', true);
        }
        return 0;
    }

    $('body').on('change','#question_topics', function () {
        op = $(this).find(':selected');
        if(op.val() != '0'){
            questionOptionRecursive(op);
            $(this).find('option').prop('selected', function() {
                return this.defaultSelected;
            });
        }
    });

    $('body').on('click', '.topics_close', function(){
        $(this).closest('.topics').remove();
        $('#question_topics').children('option[value="' + $(this).attr('id') + '"]').removeAttr('disabled');
    });

    // função para remover resposta no formulario
    $('body').on('click','.remove-answer', function(e) {
            $(this).closest('.answer').remove();            
        });
    $('body').on('click','.page-link', function(e) {
        e.preventDefault();
        var query = $(this).closest('#dashboard-content').find('input[name=query]').val();
        if($(this).attr('rel') == 'next'){
            var page = parseInt($(this).closest('ul').find('li.active').children('span').text(), 10);
            page += 1;
        }else if($(this).attr('rel') == 'prev'){
            var page = parseInt($(this).closest('ul').find('li.active').children('span').text(), 10);
            page -= 1;
        }else{            
            var page = $(this).text();
        }
        if(query != null){
            if(query.indexOf('topic') != -1){
                redirect('search/topic/' + query.split('_')[1] + '?page=' + page);
            }else{
                redirect('search/' + query.split('_')[1] + '?page=' + page);
            }
        }else{
            redirect('questions?page=' + page);
        }
    });

    $('body').on('click','#exchange_topic', function (e) {
        e.preventDefault();
        $('#select_topics option').each(function(){
            $(this).attr('disabled', false);
        });
        var id = $(this).data('id');
        var parent_topic_id = $(this).data('parent-id');
        $('#exchange_topic_modal').find('.modal-body input[name=parent_topic_id]').val(parent_topic_id);
        $('#exchange_topic_modal').find('.modal-body input[name=topic_id]').val(id);
        $('#exchange_topic_modal').modal('toggle');
        $('#select_topics option').each(function(){
            if($(this).val() == id){
                questionOptionRecursive($(this));
            }
        });
    });

    $('body').on('focusout', 'input[name=identifier]', function() {
        var identifier_field = $(this);
        axios
        .post(APP_URL+'/dashboard/questions/exists', {'identifier' : identifier_field.val()})
        .then(function(response) {
            console.log(response);
            if(response.data != ''){
                identifier_field.parent().parent().parent().find('.verify_question').html("<span class='text-danger text-bold'><i class='fas fa-exclamation-circle fa-2x'></i> <b>Questão existente no sistema.</b></span>");
            }else{
                identifier_field.parent().parent().parent().find('.verify_question').html("<i class='fas fa-check-circle fa-2x text-success'></i>");                
            }
            // $('body').closest('input[name=verify_question]').html("Existe")
            // window.location.replace(APP_URL+'/dashboard/questions');
            // window.location.reload();
        })
        .catch(function(response) {
            console.log(response);

        });
    });

    // funcao para enviar os dados de uma questão para o backend e processar a resposta
    $('body').on('submit','.question-form', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if($(this).find('textarea[name=question_wording]').summernote('isEmpty')) {
                alert('Preencha o enunciado.');
                $(this).find('textarea[name=question_wording]').focus();
                return "error";
            }      
            if($(this).find('.verify_question').text().indexOf('Questão') > 0){
                alert('A questão já existe no sistema, favor utilizar um outro identificador.');
                $(this).find('input[name=identifier]').focus();
                return "error";
            }

            // armazena o dado em um objeto
            var data = {};
            data['question_id'] = $(this).find('input[name=question_id]').val();
            data['question_wording'] = $(this).find('textarea[name=question_wording]').val();
            data['year'] = $(this).find('input[name=year]').val();
            data['agency'] = $(this).find('input[name=agency]').val();
            data['board'] = $(this).find('input[name=board]').val();
            data['exam'] = $(this).find('input[name=exam]').val();
            data['identifier'] = $(this).find('input[name=identifier]').val();
            
            data['topics'] = [];
            $(this).find('.topics').each(function() {
                data['topics'].push($(this).attr('id'));
            });

            data['answers'] = [];
            $(this).find('.answer').not('#empty_answer').each(function() {
                data['answers'].push({ 
                    'right_one' : $(this).find('#right-one').prop('checked'),
                    'answer_wording' : $(this).find('textarea[name=answer_wording]').val()
                });
            });
            $(this).find('#send_question').attr('disabled', true);
            $('#loading-create-question').show();

            // cria a requisição para salvar os dados no banco de dados
            axios
            .post(APP_URL+'/dashboard/questions/store', data)
            .then(function(response) {
                console.log(response);
                $('#loading-create-question').hide();
                redirect(last_page);
                // window.location.replace(APP_URL+'/dashboard/questions');
                // window.location.reload();
            })
            .catch(function(response) {
                console.log(response);
            });
            e.stopImmediatePropagation();
        });

    // funcao para enviar os dados de uma questão para o backend e processar a resposta
    $('body').on('submit','.exam-form', function(e) {
                e.preventDefault();
                e.stopPropagation();

                axios.post( APP_URL + '/dashboard/exams/store', $(this).serialize()).then(function (response) {
                    redirect( 'exams/create?exam_id=' + response.data.id );
                });

                // TODO
                // armazena o dado em um objeto
                // var data = {};
                // data['question_id'] = $(this).find('input[name=question_id]').val();
                // data['question_wording'] = $(this).find('textarea[name=question_wording]').val();
                //
                // data['year'] = $(this).find('input[name=year]').val();
                // data['agency'] = $(this).find('input[name=agency]').val();
                // data['board'] = $(this).find('input[name=board]').val();
                // data['identifier'] = $(this).find('input[name=identifier]').val();
                //
                //
                // data['answers'] = [];
                //
                // $(this).find('.answer').not('#empty_answer').each(function() {
                //     data['answers'].push({
                //         'right_one' : $(this).find('#right-one').prop('checked'),
                //         'answer_wording' : $(this).find('textarea[name=answer_wording]').val()
                //     });
                // });
                //
                // // cria a requisição para salvar os dados no banco de dados
                // axios
                //     .post(APP_URL+'/dashboard/questions/store', data)
                //     .then(function(response) {
                //         console.log(response);
                //         redirect('questions');
                //         // window.location.replace(APP_URL+'/dashboard/questions');
                //         // window.location.reload();
                //     })
                //     .catch(function(response) {
                //         console.log(response);
                //     });
                // e.stopImmediatePropagation();
            });

    $('body').on('click', '.attach-question', function (e) {

        let question_id = $(this).data('question_id');
        let exam_id = $(this).data('exam_id');

        axios.post( APP_URL + '/dashboard/exams/add_question',{
            'exam_id' : exam_id,
            'question_id' : question_id
        }).then(function (response) {
            $('.question-' + question_id + ' .attach-question').hide();
            $('.question-' + question_id + ' .detach-question').show();
            $('#questions_added_section #questions').html(response.data);
            let nquestions = $('#questions_added_section #questions .question-picker').length;
            var r='';
            if ( nquestions > 0 ){
                r = '('+nquestions+')';
            }
            $('#add_questions_length').html(r);
        });
    });

    $('body').on('click', '.detach-question', function (e) {

        let question_id = $(this).data('question_id');
        let exam_id = $(this).data('exam_id');

        axios.post( APP_URL + '/dashboard/exams/remove_question',{
            'exam_id' : exam_id,
            'question_id' : question_id
        }).then(function (response) {
            $('.question-' + question_id + ' .detach-question').hide();
            $('.question-' + question_id + ' .attach-question').show();
            $('#questions_added_section #questions').html(response.data);
            let nquestions = $('#questions_added_section #questions .question-picker').length;
            var r='';
            if ( nquestions > 0 ){
                r = '('+nquestions+')';
            }
            $('#add_questions_length').html(r);
        });
    });

    $('body').on('submit', '#questions_add_section #search_question', function (e) {
        e.preventDefault();
        axios.get( APP_URL + '/dashboard/questions/search?'+ $(this).serialize()).then(function(response) {
            $('#questions_add_section #questions').html(response.data);
        });
    });

    // funcao para enviar os dados de um usuário para o backend e processar a resposta
    $('body').on(
        'submit',
        '.user-form', 
        function(e) {
            e.preventDefault();
            e.stopPropagation();
            // Traz todos os campos do formulário
            var data = new FormData($('.user-form')[0]);
            
            // Adiciona o campo oculto do e-mail
            data.append('user_email', $('.user-form').find('input[name=user_email]').val());
            data.append('user_avatar', $('.user-form').find('input[name=user_avatar]').val());

            // Adiciona apenas o nome da imagem
            data.append('avatar', $('.user-form').find('img[name=avatar]').attr('src').replace(/^.*[\\\/]/, ''));            
            // cria a requisição para salvar os dados no banco de dados
            
            axios
            .post(APP_URL+'/dashboard/user/store', data)
            .then(function(response) {
                console.log(response);
                redirect('user');
                // window.location.reload();
            })
            .catch(function(response) {
                console.log(response);
            });
            e.stopImmediatePropagation();
        }
    );

    $('body').on(
        'submit',
        '.navbar-form', 
        function(e) {
            e.preventDefault();
            $("li").removeClass('active');
            $('#question-menu').addClass('active');
            var data = new FormData($('.navbar-form')[0]);
            redirect('search/'+data.get('search'))
        }
    );
    $( 'body' ).on( 'click','.topic-link', function (e){
        e.preventDefault();
        e.stopPropagation();
        $("li").removeClass('active');
        $('#question-menu').addClass('active');
        redirect('search/topic/' + $(this).attr('data-id'));
    });
    
    $( 'body' ).on( 'click','.remove-avatar', function (e){
        e.preventDefault();
        e.stopPropagation();
        // alert($('.user-form').find('img[name=avatar]').attr('src').replace(/^.*[\\\/]/, ''));
        var data = {
            'id': 
                $('.user-form').find('input[name=user_id]').val() ,
            'avatar' : 
                $('.user-form').find('img[name=avatar]').attr('src').replace(/^.*[\\\/]/, '')
        };
        axios
            .post(APP_URL+'/dashboard/user/deleteAvatar', data)
            .then(function(response) {
                console.log(response);
                redirect('user');
                // window.location.reload();
            })
            .catch(function(response) {
                console.log(response);
            });
    });

    $( 'body' ).on( 'click','.delete-question', function (e){
        e.preventDefault();
        e.stopPropagation();
        // alert($('.user-form').find('img[name=avatar]').attr('src').replace(/^.*[\\\/]/, ''));
        var data = {'id': $(this).parent().find('input[name=question_id]').val()};
        $('#loading-delete-question').show();
        $(this).parent().find('button').attr('disabled', true);

        axios
            .post(APP_URL+'/dashboard/questions/delete', data)
            .then(function(response) {
                $('#loading-delete-question').hide();
                $('#delete_question_modal').modal('toggle');
                $(this).parent().find('button').attr('disabled', false);
                $('#response_modal .modal-title').html("Sucesso!");
                $('#response_modal .modal-body').html("A questão foi apagada do sistema com sucesso!");
                $('#response_modal .modal-footer').html('<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>');
                setTimeout(function(){
                    $('#response_modal').modal('toggle');
                }, 200);
                console.log(response);
            })
            .catch(function(response) {
                console.log(response);
            });
    });

    $('body').on('click', '.nav-opt-sim a', function (e) {
        $('#simulation_create_mode').val( $(this).data('simulation_create_mode'));
    })

    $('body').on('submit', '#simulation_form', function (e) {

        e.preventDefault();
        var form_payload = $(this);
        var topics_payload = [];
        $('.choosen_topics > div.topics').each(function () {
            topics_payload.push( parseInt($(this).attr('id')));
        });
        var agency = form_payload.find('#agency').val();
        var exam = form_payload.find('#exam').val();
        var board = form_payload.find('#board').val();
        var simulation_create_mode = form_payload.find('input[name=simulation_create_mode]').val();

        let submit_payload = {
            'number_questions' : form_payload.find('input[name=number_questions]').val(),
            'topics' : topics_payload,
            'agency' : agency,
            'board' : board,
            'exam' : exam,
            'simulation_create_mode' : simulation_create_mode
        };

        axios.post( APP_URL + '/dashboard/simulations/store', submit_payload ).then(function (response) {
            redirect('simulations/'+response.data.simulation_id+'/'+response.data.exam_user_id);
            // redirect(
            //     'simulation?id=' + response.data.simulation_id + '&' +
            //     'exam_user_id='+ response.data.exam_user_id
            // );
        })
    });

    $('body').on('click','.display-question',function (e) {
        let simulation_id = $('#fields #simulation_id').val();
        let user_id = $('#fields #user_id').val();
        let exam_user_id = $('#fields #exam_user_id').val();
        let paginate = $('select[name=num_questions]').val();
        let page = $(this).data('page');
        axios.get( APP_URL + '/dashboard/simulations/display_question?' +
            'simulation_id='+simulation_id + '&' +
            'user_id=' + user_id + '&' +
            'exam_user_id=' + exam_user_id + '&' +
            'paginate=' + paginate + '&' +
            'page=' + page
        ).then(function (response) {
           $('#current_question').html(response.data);
        });
    });

    $('body').on('change', 'select[name=num_questions]', function () {
        let simulation_id = $('#fields #simulation_id').val();
        let user_id = $('#fields #user_id').val();
        let exam_user_id = $('#fields #exam_user_id').val();
        let paginate = $('select[name=num_questions]').val();
        let page = 1;
        axios.get( APP_URL + '/dashboard/simulations/display_question?' +
            'simulation_id='+simulation_id + '&' +
            'user_id=' + user_id + '&' +
            'exam_user_id=' + exam_user_id + '&' +
            'paginate=' + paginate + '&' +
            'page=' + page
        ).then(function (response) {
            $('#current_question').html(response.data);
        });
    });

    $('body').on('click','.finish-simulation',function (e) {

        let exam_user_id = $('#fields #exam_user_id').val();

        axios.post( APP_URL + '/dashboard/simulations/finish_simulation' ,{'exam_user_id' : exam_user_id}).then(function (response) {
            redirect('simulations');
        }).catch(function (error){
            alert(error.response.data) ;
        });
    });

    $('body').on('change', '.select_answer', function (e) {
        let payload = {
            'exam_user_id' : $(this).data('exam_user_id'),
            'answer_id'    : $(this).data('answer_id')
        };
        axios.post( APP_URL + '/dashboard/exams/answer_question', payload).then(function (response) {

        });
    });

    $('body').on('submit', '#import_form', function (e) {

        e.preventDefault();
        e.stopPropagation();
        // Traz todos os campos do formulário
        var data = new FormData($(this)[0]);
        // // Adiciona o campo oculto do e-mail
        // data.append('user_email', $('.user-form').find('input[name=user_email]').val());
        // data.append('user_avatar', $('.user-form').find('input[name=user_avatar]').val());

        // // Adiciona apenas o nome da imagem
        // data.append('avatar', $('.user-form').find('img[name=avatar]').attr('src').replace(/^.*[\\\/]/, ''));            
        // // cria a requisição para salvar os dados no banco de dados
        $('#loading-import').show();
        $('#submit-import').attr('disabled', true);
        axios
        .post(APP_URL+'/dashboard/upload', data)
        .then(function(response) {
            $('#loading-import').hide();
            $('#submit-import').attr('disabled', false);
            $('#upload_modal').modal('toggle');
            $('#response_modal .modal-title').html("Sucesso!");
            $('#response_modal .modal-body').html("Seu arquivo foi enviado com sucesso! As questões estão sendo processadas no momento.");
            $('#response_modal .modal-footer').html('<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>');
            setTimeout(function(){
                $('#response_modal').modal('toggle');
            }, 200);
            // window.location.reload();
        })
        .catch(function(response) {
            $('#loading-import').hide();
            $('#submit-import').attr('disabled', false);
            $('#upload_modal').modal('toggle');
            $('#response_modal .modal-title').html("Erro!");
            $('#response_modal .modal-body').html("Erro ao processar o arquivo. Verifique se o mesmo está no formato UTF-8 e se está no padrão de leitura do site.");
            $('#response_modal .modal-footer').html('<button type="button" class="btn btn-danger" data-dismiss="modal">Ok</button>');
            setTimeout(function(){
                $('#response_modal').modal('toggle');
            }, 200);
            // console.log(response);
        });
        e.stopImmediatePropagation();
    });

    $('body').on('click', '.btn-return-question', function(e){
        e.preventDefault();
        redirect(last_page);
    });

    $('body').on('hidden.bs.modal', '#response_modal', function(){
        setTimeout(function(){
            redirect(last_page);
        }, 200);
    });

    $('body').on('click', '.btn-return-simulation', function(e){
        e.preventDefault();
        if($('input[name=exam_state]').val() != 'COMPLETED'){
            $('#close_exam').modal('toggle');
        }else{
            redirect('simulations');
        }
    });

    $('body').on('hidden.bs.modal', '#close_exam', function(){
        setTimeout(function(){
            redirect('simulations');
        }, 200);
    });

    $('body').on('click', '.url.fas.fa-eraser', function (){
        $('.modal-body').find('input[name=url]').val('');
    });

    $('body').on('submit','.form-add-comment', function (e) {
        let form = $(this);
        let question_id = form.data('id');
        e.preventDefault();
        axios.post(APP_URL+'/dashboard/questions/comments', form.serialize()).then(function (response) {
            $('.question-' + question_id + ' .wrapper-comments').append(
                '<div class="comment">'+
                    '<div class="h">'+response.data.author_name+' disse:</div>'+
                    '<div class="b">'+response.data.description+'</div>'+
                    '<div class="f">'+response.data.date+'</div>'+
                '</div>'
            );
            form.trigger('reset');
            $('.question-'+question_id+' #number_comments').html(parseInt($('.question-'+question_id+' #number_comments').html()) +1);
        }).catch(function (error) {
            console.log(error);
        });
    });

    $('body').on('click','.backup-create', function () {
        axios.post( APP_URL + '/dashboard/backups/create').then(function (response) {
            alert('backup criado com sucesso');
            window.location.href = APP_URL + '/dashboard/backups/get_snapshot?name='+response.data.name;
        }).catch(function (error) {
            alert('ocorreu um erro durante a criação do backup');
        });
    });

    $('body').on('click','.backup-load', function () {
        $('input[name=snapshot]').trigger('click');
    });

    $('body').on('change','input[name=snapshot]', function () {
        $('#snapshot-form').trigger('submit');

    });

    $('body').on('submit','#snapshot-form', function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        axios.post( APP_URL + '/dashboard/backups/load', formData).then(function (response) {
            alert('backup aplicado com sucesso');
        }).catch(function (error) {
            alert('ocorreu um erro durante a criação do backup');
        });
    })

    $('body').on('click', '#refresh', function(e){
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "/dashboard/refresh",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
        .done(function(){
            alert('A busca está sendo atualizada, aguarde ao menos 1 minuto para fazer novas buscas.');
        }).fail(function() {
            alert('Ocorreu um erro durante a atualização, contate o administrador do sistema.');
        });
    });
});