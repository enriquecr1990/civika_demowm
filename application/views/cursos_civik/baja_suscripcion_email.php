<?php $this->load->view('default/header'); ?>

<div class="container">

    <div class="card mb-3">
        <div class="card-header">
            <label>Baja suscripción</label>
        </div>
        <div class="card-body">

            <form id="form_baja_suscripcion" method="get" action="<?=base_url()?>InscripcionesCTN/baja_suscripcion_mail">
                <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="email">Email<span
                        class="requerido">*</span></label>
                        <input  class="form-control" id="email" placeholder="Email"
                        name="email"  data-rule-required="true"  type="email" >
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Aceptar</button>
                <a href="<?=base_url()?>GaleriaCTN" class="btn btn-danger">Cancelar</a>    

                  
           </form>
       </div>
   </div>
</div>

<?php $this->load->view('default/footer'); ?>