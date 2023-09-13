<?php if(isset($paginas) && $paginas > 1): ?>
	<!-- /.card-body -->
	<div class="card-footer">
		<nav aria-label="Contacts Page Navigation">
			<ul class="pagination justify-content-center m-0">
				<?php for($i = 1; $i <= $paginas; $i++): ?>
					<li class="page-item <?=isset($pagina_select) && $pagina_select == $i ? 'active':''?>"><a class="page-link" href="<?=isset($url_paginacion) ? $url_paginacion.'' : '#'?>"><?=$i?></a></li>
				<?php endfor; ?>
			</ul>
		</nav>
	</div>
	<!-- /.card-footer -->
<?php endif; ?>
