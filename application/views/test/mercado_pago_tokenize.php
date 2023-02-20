<?php $this->load->view('default/header'); ?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <label>Pruebas mercado pago - tokenize</label>
        </div>
        <div class="card-body">
            <?php $this->load->view('payments/mercado_pago/form_tokenize'); ?>
        </div>
    </div>
</div>


<?php $this->load->view('default/footer'); ?>

