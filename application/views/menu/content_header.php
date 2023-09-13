<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0"><?=isset($titulo_pagina) ? $titulo_pagina : 'Sistema Integral de portafolio de evidencias PED'?></h1>
			</div><!-- /.col -->
			<?php if(isset($migas_pan)): ?>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<?php foreach ($migas_pan as $mp): ?>
							<?php if($mp['activo']): ?>
								<li class="breadcrumb-item active"><?=$mp['nombre']?></li>
							<?php else: ?>
								<li class="breadcrumb-item"><a href="<?=$mp['url']?>"><?=$mp['nombre']?></a></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ol>
				</div><!-- /.col -->
			<?php endif; ?>
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
