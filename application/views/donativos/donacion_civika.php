<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>

<div class="container">

    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Donativos a favor de Fundación Civika con Mercado pago</h5>
                    <div class="card-body text-justify">
                        <a mp-mode="dftl"
                           href="https://www.mercadopago.com/mlm/checkout/start?pref_id=265303870-8d7f577d-b17e-4c95-a23a-297a7940c587"
                           name="MP-payButton" class='btn btn-info btn-sm'>Donativo
                        </a>
                        <br><span>Donativo a su elección</span>
                        <a style="font-size:15px; font-weight:bold; border-radius: 50px; background: rgb(40, 83, 111); border: 1px solid rgb(41, 62, 117);
                            text-shadow: rgb(41, 62, 117) 1px 1px;
                            background: rgb(40, 83, 111) url('https://secure.mlstatic.com/mptools/assets/MP-payButton-blue.png') repeat scroll 0% 0%;" class="btn btn-primary btn-sm btn-pill" href="http://mpago.la/4JcB" target="popup" onClick="window.open(this.href, this.target, 'width=600,height=660'); return false;">
                            Donativo
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Donativos a favor de Fundación Civika PayPal</h5>
                    <div class="card-body text-justify">
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="hosted_button_id" value="U5CVVLLSYGY28">
                            <input type="image" src="https://www.paypalobjects.com/es_XC/MX/i/btn/btn_donateCC_LG.gif" border="0"
                                   name="submit" alt="PayPal, la forma más segura y rápida de pagar en línea.">
                            <img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Donativos a favor de Fundación Civika Visa Checkout</h5>
                    <div class="card-body text-justify">
                        <img alt="Visa Checkout" class="v-button" role="button"
                             src="https://sandbox.secure.checkout.visa.com/wallet-services-web/xo/button.png"/>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>