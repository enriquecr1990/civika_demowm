<div class="row">
    <div class="form-group col-lg-2 col-md-6 col-sm-12">
        <img class="img-fluid img-thumbnail" src="<?= base_url() ?>extras/imagenes/logo/payments/mercadopago.jpg"
             alt="Mercado Pago MX"/>
    </div>
    <div class="form-group col-lg-2 col-md-6 col-sm-12">
        <form action="<?=isset($url_payment) ? $url_payment : base_url().'no_existe_funcion'?>" method="POST">
            <script src="<?=SRC_JS_MP?>"
                    data-button-label="Pago online"
                    data-summary-product-label="<?=isset($details_payment) ? $details_payment : 'Curso impartido por CIVIKA'?>"
                    data-summary-product="654"
                    data-public-key="<?=PUBLIC_KEY_MP?>"
                    <?=isset($reintentar) && $reintentar ? 'data-open="true"':''?>
                    data-transaction-amount="<?=$transaction_amount?>">
            </script>
        </form>
    </div>
</div>