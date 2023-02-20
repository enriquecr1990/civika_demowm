<?php if($total_registros > $limit_select): ?>
    <div class="row" id="<?=$id_paginacion?>">

        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-12">
            <select class="custom-select stl_pagina change_input_paginacion"
                    data-form_busqueda="<?=$form_busqueda?>"
                    data-url_paginacion="<?=$url_paginacion?>"
                    data-conteiner_resultados="<?=$conteiner_resultados?>"
                    data-id_paginacion="#<?=$id_paginacion?>" data-is_limit="0">
                <?php for($i = 1; $i <= $paginas; $i++): ?>
                    <option value="<?=$i?>" <?=$pagina_select == $i ? 'selected="selected"':''?>><?=$i?></option>
                <?php endfor; ?>
            </select>
            <span class="help-span">Total de páginas: <?=$paginas?></span>
        </div>

        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-12">
            <select class="custom-select slt_limit change_input_paginacion"
                    data-form_busqueda="<?=$form_busqueda?>"
                    data-url_paginacion="<?=$url_paginacion?>"
                    data-conteiner_resultados="<?=$conteiner_resultados?>"
                    data-id_paginacion="#<?=$id_paginacion?>" data-is_limit="1">
                <option value="5" <?=$limit_select == 5 ? 'selected="selected"':''?>>5</option>
                <option value="10" <?=$limit_select == 10 ? 'selected="selected"':''?>>10</option>
                <option value="20" <?=$limit_select == 20 ? 'selected="selected"':''?>>20</option>
                <option value="50" <?=$limit_select == 50 ? 'selected="selected"':''?>>50</option>
                <option value="100" <?=$limit_select == 100 ? 'selected="selected"':''?>>100</option>
            </select>
            <span class="help-span">Registros a mostrar por búsqueda</span>
        </div>

        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-12 text-right">
            <span class="badge badge-pill badge-outline-info">Total de <?=$tipo_registro?> en el sistema: <?=$total_registros?></span>
        </div>

    </div>
<?php endif; ?>