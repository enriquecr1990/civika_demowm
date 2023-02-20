<p class="centrado">
    <label>DATOS FACTURACIÓN:</label>
<table class="w100 bordes">
    <tr>
        <td class="w30 relleno">Razón social:</td>
        <td><?=$factura->razon_social?></td>
    </tr>
    <tr>
        <td class="w30 relleno">RFC:</td>
        <td><?=$factura->rfc?></td>
    </tr>
    <tr>
        <td class="w30 relleno">Domicilio fiscal:</td>
        <td><?=$factura->direccion_fiscal?></td>
    </tr>
    <tr>
        <td class="w30 relleno">Correo eléctronico:</td>
        <td><?=$factura->correo?></td>
    </tr>
    <tr>
        <td class="w30 relleno">Uso de CFDI:</td>
        <td><?=$factura->uso_cfdi?></td>
    </tr>
</table>
</p>