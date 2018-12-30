<div class="container-fluid text-center">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col">
					<p class=" simple-text logo-normal"><h3><u class="color-orange">{{Auth::user()->name}}</u></h3></p>
				</div>
			</div>
		</div>		
		<div class="card-body">
			<div class="row">
				<div class="col">
					<p>
				        Seja bem vindo(a) ao Dashboard do site Só Questões.
				    </p>
				</div>
			</div>			
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4">
			<a href="#" id="user" class="dashboard-menu">
			<div class="card">
				<div class="card-header text-primary">
						<span class="fa-stack fa-4x">
							<i class="fas fa-circle-notch fa-stack-2x"></i>
							<i class="fas fa-user fa-stack-1x"></i>
						</span>
					<p class="mb-0">Usuário</p></div>
				<hr class="my-0">
				<div class="card-body">
		    		<p class="card-text">Acesso aos seus dados e estatísticas.</p>
				</div>
			</div>
			</a>
		</div>
		<div class="col-md-4">
			<a href="#" id="questions" class="dashboard-menu">
				<div class="card">
					<div class="card-header text-primary">
							<span class="fa-stack fa-4x">
								<i class="fas fa-circle-notch fa-stack-2x"></i>
								<i class="fas fa-question-circle fa-stack-1x"></i>
							</span>
						<p class="mb-0">Questões</p>
					</div>
					<hr class="my-0">
					<div class="card-body">
			    		<p class="card-text">Acesso às perguntas disponíveis.</p>
					</div>
				</div>
			</a>
		</div>
		<div class="col-md-4">
			<a href="#" id="simulations" class="dashboard-menu">
				<div class="card">
					<div class="card-header text-primary">
						<span class="fa-stack fa-4x">
							<i class="fas fa-circle-notch fa-stack-2x"></i>
							<i class="fas fa-clipboard-list fa-stack-1x"></i>
						</span>
						<p class="mb-0">Simulados</p>
					</div>
					<hr class="my-0">
					<div class="card-body">
			    		<p class="card-text">Crie e responda seus simulados.</p>
					</div>
				</div>
			</a>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-4">
			<a href="#" id="topics" class="dashboard-menu">
				<div class="card">
					<div class="card-header text-primary">
						<span class="fa-stack fa-4x">
							<i class="fas fa-circle-notch fa-stack-2x"></i>
							<i class="fas fa-book fa-stack-1x"></i>
						</span>
						<p class="mb-0">Tópicos</p>
					</div>
					<hr class="my-0">
					<div class="card-body">
			    		<p class="card-text">Crie tópicos para classificar questões.</p>
					</div>
				</div>
			</a>
		</div>
		<div class="col-md-4">
			<a href="#" id="exams" class="dashboard-menu">
				<div class="card">
					<div class="card-header text-primary">
						<span class="fa-stack fa-4x">
							<i class="fas fa-circle-notch fa-stack-2x"></i>
							<i class="fas fa-file-alt fa-stack-1x"></i>
						</span>
						<p class="mb-0">Provas</p>
					</div>
					<hr class="my-0">
					<div class="card-body">
			    		<p class="card-text">Crie e responda suas provas.</p>
					</div>
				</div>
			</a>
		</div>		
		<div class="col-md-2"></div>
	</div>
    
</div>