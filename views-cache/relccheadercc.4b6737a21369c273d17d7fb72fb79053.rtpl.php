<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Título do Centro de Custo -->
<?php if( $unidade != '' ){ ?>

<tr>
    <td colspan=9><strong>UNIDADE: <?php echo htmlspecialchars( $unidade, ENT_COMPAT, 'UTF-8', FALSE ); ?></strong></td>
</tr>
<?php } ?>

<?php if( $grupo != '' ){ ?>

<tr>
    <td colspan=9><strong>GRUPO: <?php echo htmlspecialchars( $grupo, ENT_COMPAT, 'UTF-8', FALSE ); ?></strong></td>
</tr>
<?php } ?>

<?php if( $subgrupo != '' ){ ?>

<tr>
    <td colspan=9><strong>SUBGRUPO: <?php echo htmlspecialchars( $subgrupo, ENT_COMPAT, 'UTF-8', FALSE ); ?></strong></td>
</tr>
<?php } ?>


<tr>
    <td colspan=9 style='border-bottom: 1px solid black;'><strong>CENTRO DE CUSTO: <?php echo htmlspecialchars( $id_CentroCusto, ENT_COMPAT, 'UTF-8', FALSE ); ?> - <?php echo htmlspecialchars( $DescCentroCusto, ENT_COMPAT, 'UTF-8', FALSE ); ?></strong></td>
</tr>
<!-- FIM Título do Centro de Custo -->

<!-- Título dos Meses -->
<tr>
    <td></td>
    <td align=right><b><?php echo htmlspecialchars( $mes1, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $ano, ENT_COMPAT, 'UTF-8', FALSE ); ?></b></td>
    <td align=right>%</td>
    <td align=right><b><?php echo htmlspecialchars( $mes2, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $ano, ENT_COMPAT, 'UTF-8', FALSE ); ?></b></td>
    <td align=right>%</td>
    <td align=right><b><?php echo htmlspecialchars( $mes3, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $ano, ENT_COMPAT, 'UTF-8', FALSE ); ?></b></td>
    <td align=right>%</td>
    <td align=right><b><?php echo htmlspecialchars( $mes4, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $ano, ENT_COMPAT, 'UTF-8', FALSE ); ?></b></td>
    <td align=right>%</td>
</tr>
<!-- FIM Título dos Meses -->
