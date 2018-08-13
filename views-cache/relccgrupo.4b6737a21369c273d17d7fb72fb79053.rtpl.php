<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Grupo de Lançamento -->
<tr>
    <td colspan=9><b><?php echo htmlspecialchars( $totalgrupo["DescGrupoItemCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?></b></td>
</tr>
<!-- FIM Grupo de Lançamento -->

<!-- Ítem de Lançamento por mês e % -->
<?php $counter1=-1;  if( isset($grupo) && ( is_array($grupo) || $grupo instanceof Traversable ) && sizeof($grupo) ) foreach( $grupo as $key1 => $value1 ){ $counter1++; ?>

<tr>
    <td><?php echo htmlspecialchars( $value1["DescItemCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
    <td align=right><?php echo formatValor($value1["Mes1"]); ?></td>
    <td align=right><?php echo formatPercent($value1["Mes1"], $totalcc["Mes1"]); ?></td>
    <td align=right><?php echo formatValor($value1["Mes2"]); ?></td>
    <td align=right><?php echo formatPercent($value1["Mes2"], $totalcc["Mes2"]); ?></td>
    <td align=right><?php echo formatValor($value1["Mes3"]); ?></td>
    <td align=right><?php echo formatPercent($value1["Mes3"], $totalcc["Mes3"]); ?></td>
    <td align=right><?php echo formatValor($value1["Mes4"]); ?></td>
    <td align=right><?php echo formatPercent($value1["Mes4"], $totalcc["Mes4"]); ?></td>
</tr>
<?php } ?>


<!-- FIM Ítem de Lançamento por mês e % -->

<!-- Total do Grupo -->
<tr>
    <td align=left><b>TOTAL: </b></td>
    <td align=right><b><?php echo formatValor($totalgrupo["Mes1"]); ?></b></td>
    <td align=right><b><?php echo formatPercent($totalgrupo["Mes1"], $totalcc["Mes1"]); ?></b></td>
    <td align=right><b><?php echo formatValor($totalgrupo["Mes2"]); ?></b></td>
    <td align=right><b><?php echo formatPercent($totalgrupo["Mes2"], $totalcc["Mes2"]); ?></b></td>
    <td align=right><b><?php echo formatValor($totalgrupo["Mes3"]); ?></b></td>
    <td align=right><b><?php echo formatPercent($totalgrupo["Mes3"], $totalcc["Mes3"]); ?></b></td>
    <td align=right><b><?php echo formatValor($totalgrupo["Mes4"]); ?></b></td>
    <td align=right><b><?php echo formatPercent($totalgrupo["Mes4"], $totalcc["Mes4"]); ?></b></td>
</tr>
<!-- FIM Total do Grupo -->
