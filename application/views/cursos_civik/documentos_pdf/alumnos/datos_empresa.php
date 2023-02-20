<p class="centrado">
    <label>DATOS EMPRESA:</label>
<table class="w100 bordes">
    <tr>
        <td class="w30 relleno">Nombre:</td>
        <td><?=$empresa->nombre?></td>
    </tr>
    <tr>
        <td class="w30 relleno">RFC:</td>
        <td><?=$empresa->rfc?></td>
    </tr>
    <tr>
        <td class="w30 relleno">Domicilio fiscal:</td>
        <td><?=$empresa->domicilio?></td>
    </tr>
    <tr>
        <td class="w30 relleno">Correo eléctronico:</td>
        <td><?=$empresa->correo?></td>
    </tr>
    <tr>
        <td class="w30 relleno">Teléfono:</td>
        <td><?=$empresa->telefono?></td>
    </tr>

    <tr>
        <td class="w30 relleno">Representante legal:</td>
        <td><?=$empresa->representante_legal?></td>
    </tr>
    <tr>
        <td class="w30 relleno">Representante de trabajadores:</td>
        <td><?=$empresa->representante_trabajadores?></td>
    </tr>
</table>
</p>