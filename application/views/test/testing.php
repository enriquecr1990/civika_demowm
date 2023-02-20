<?php $this->load->view('default/header') ?>

<div class="container-fluid">

<!-- TinyMCE -->
<script src="<?=base_url().'extras/plugins/editorWord/tiny_mce.js'?>"></script>
<script src="<?=base_url().'extras/plugins/editorWord/tiny.js'?>"></script>
  
<form>
      <div class="container-fluid">
            <textarea class="form-control" id="elm1" name="elm1" rows="15" cols="80" style="width: 80%">
            </textarea>
       <input type="submit" name="save" value="Submit" />
        <input type="reset" name="reset" value="Reset" />
       </div>
</form>
</div>

<div id="conteiner_operacion_inscripcion_alumno"></div>

<?php $this->load->view('default/footer') ?>