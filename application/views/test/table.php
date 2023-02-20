<?php $this->load->view('default/header') ?>
<?php


 $Nombre = array();

 $Nombre[] = "TEMARIO";
 $Nombre[] = "Sub Tema";
 $Nombre[] = "SubTema";
?>

  <div class="container-fluid">
    <div class="container-fluid">
      <table class="table table-hover">
      <thead>
      <tr>
       <th> Temarios </th>
       </tr> 
      </thead>
      <tbody>
         <?php
      for ($i=0; $i < count($Nombre); $i++) 
        {
          echo "<tr>";
          echo "<td>".$Nombre[$i]."</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
  </table>
  </div>
</div>
 
<?php $this->load->view('default/footer') ?>