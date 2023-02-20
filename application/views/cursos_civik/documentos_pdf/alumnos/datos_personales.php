<p class="centrado">
    <label>DATOS PERSONALES:</label>
<table class="w100 bordes">
    <tr>
        <td class="w30 relleno">Nombre:</td>
        <td><?=$alumno->nombre.' '.$alumno->apellido_p.' '.$alumno->apellido_m?></td>
    </tr>
    <tr>
        <td class="w30 relleno">Teléfono:</td>
        <td><?=$alumno->telefono?></td>
    </tr>
    <tr>
        <td class="w30 relleno">Correo electrónico:</td>
        <td><?=$alumno->correo?></td>
    </tr>
    <tr>
        <td class="w30 relleno">CURP:</td>
        <td><?=$alumno->curp?></td>
    </tr>
    <tr>
        <td class="w30 relleno">Puesto:</td>
        <td><?=$alumno->puesto?></td>
    </tr>
    <tr>
        <td class="w30 relleno">Ocupación específica:</td>
        <td><?=$alumno->ocupacion_especifica?></td>
    </tr>
</table>
</p>