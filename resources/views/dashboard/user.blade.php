{{-- <script src="{{ asset('js/dashboard.js') }}"></script> --}}
<form class="user-form">
    <div class="content-margin-top">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title">Perfil</h4>
                                    <p class="card-category">Atualize seu perfil</p>
                                </div>
                                <div class="card-body">
                                        <input type="file" id="avatar_upload" name="user_avatar" style="display:none"> 
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nome</label>
                                                    <input type="text" name="user_name" class="form-control" value="{{Auth::user()->name}}">
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">E-mail</label>
                                                    <input type="text" name="user_email" class="form-control" disabled value="{{Auth::user()->email}}">
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                        <button id="update_user" type="submit" class="btn btn-primary pull-right">Atualizar</button>
                                        <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-profile">
                                <div class="card-avatar">
                                        <div class="avatar-upload">
                                            @if(is_null(Auth::user()->avatar))
                                                <img class="img-responsive rounded-circle" name='avatar' src="{{ Config::get('constants.avatar_path_access') . Config::get('constants.avatar_name') }}" alt="{{Auth::user()->name}}" width="130px" height="130px" />
                                            @else      
                                                <img class="img-responsive rounded-circle" name='avatar' src="{{Config::get('constants.avatar_path_access').Auth::user()->avatar}}" alt="{{Auth::user()->name}}" width="130px" height="130px"/>
                                            @endif
                                        </div>
                                    
                                </div>
                                <div class="card-body ">
                                    <h6 class="card-category text-gray">{{Config::get('constants.user_type.'.Auth::user()->user_type)}}</h6>
                                    <h4 class="card-title text-uppercase">{{Auth::user()->name}}</h4>
                                    <p class="card-description">
                                    <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <i class="fa fa-comments color-orange"></i> {{Auth::user()->comments->count()}}
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <i class="fas fa-file-alt color-orange"></i> {{Auth::user()->doneExams->count()}}/{{Auth::user()->createdExams->count()}}
                                    </div>
                                   {{--  <div class="col-md-3 col-sm-12">
                                        <i class="fa fa-comments"></i> {{Auth::user()->comments->count()}}
                                    </div> --}}
                                    <div class="col-md-4 col-sm-12">
                                        <i class="fas fa-clipboard-list color-orange"></i> {{Auth::user()->doneSimulations->count()}}/{{Auth::user()->createdSimulations->count()}}
                                    </div>
                                        </div>
                                    </p>
                                    {{-- <a href="#" class="remove-avatar btn btn-primary btn-round">?</a> --}}
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>

    </div>
</form>