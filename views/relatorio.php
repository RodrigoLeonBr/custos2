<?php
require('_app/Config.inc.php');

$login = new Login(3);
$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$mesano='201811';

/** DEFINE TIPO DE BUSCA
switch (get_post_action('particular', 'fusame', 'ab')) {
    case 'particular':
        //save article and keep editing
        $sqlwhere = " RE_TIPO='P'";
        break;

    case 'fusame':
        //save article and redirect
        $sqlwhere = " RE_TIPO='M'";
        break;

    case 'ab':
        //publish article and redirect
        $sqlwhere = " RE_TIPO='U'";
        break;

    default:
        //no action sent
}
*/

$sqlwhere = " RE_TIPO='P'";
if (!empty($data['SendPostForm'])):
    
endif;

if (!$login->CheckLogin()):
    unset($_SESSION['userlogin']);
    header('Location: index.php?exe=login');
else:
    $userlogin = $_SESSION['userlogin'];
endif;

if ($logoff):
    unset($_SESSION['userlogin']);
    header('Location: index.php?exe=logoff');
endif;
?>

<!DOCTYPE html>
<!-- SISTEMA DE IMPRESSÃO DE FATURAMENTO AMBULATORIAL-->
<html lang="pt-br">    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Curso de Front-End Bootstrap</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

    </head>
    <body>
    
        <?php
        /** SQL DE BUSCA DO RELATÓRIO*/
        $readRels = new Read;
        $SqlProd  = "SELECT PRD_UID, " ;        
        $SqlProd .= "p.PRD_PA PRD_PA, PRD_TPFIN, PRD_RUB, c.descricao PA_DC, ";
        $SqlProd .= "RE_CNOME UNIDADE, RE_TIPO TIPO, TIPOUNI, ";
        $SqlProd .= " substr(p.PRD_PA,1,2) GRUPO, substr(p.PRD_PA,1,4) SUBGRUPO, substr(p.PRD_PA,1,6) FORMA, ";
        $SqlProd .= "c.total PA_TOTAL, SUM(PRD_QT_P) PRD_QT_P, SUM(PRD_QT_A) PRD_QT_A, ";
        $SqlProd .= "SUM(PRD_QT_P*c.total) PRD_VL_P, SUM(PRD_VL_A) PRD_VL_A ";
        $SqlProd .= "FROM S_PRD AS p ";
        $SqlProd .= "LEFT JOIN procedimento AS c ON p.PRD_PA=c.Codigo ";
        $SqlProd .= "LEFT JOIN prestador AS u ON p.PRD_UID=u.RE_CUNID ";
        $SqlProd .= "WHERE RE_TIPO='P' AND PRD_MVM='201811' ";
        $SqlProd .= "GROUP BY PRD_UID, PRD_RUB, PRD_TPFIN, PRD_PA ";
        $SqlProd .= "ORDER BY PRD_UID, PRD_RUB, PRD_TPFIN, PRD_PA ";
        
                
        $readRels->FullRead($SqlProd);
        
        /** SQL DE BUSCA DE FINANCIAMENTO*/
        $rubs = new Read;
        $rubs->FullRead("SELECT CDN_IT as ID, CDN_DSCR as DC FROM S_CDN WHERE CDN_TB='46' UNION SELECT CONCAT(RUB_TOTAL,RUB_ID) AS ID, RUB_DC AS DC FROM S_RUB");
        $rub = $rubs->getResult();
        
        /** SQL DE BUSCA DE GRUPO, SUBGRUPO E FORMA*/
        $grupos = new Read;
        $grupos->FullRead("SELECT * FROM grupo");
        $grupo = $grupos->getResult();
        
        
        if (!$readRels->getResult()):

        else:
        /** CABEÇALHO*/
        ?>
        
        <section>
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-2">
                        <img src="brasao.jpg" width="50%"">
                        <p style="line-height: 15px; font-size: 100%">Secretaria de Saúde</p>
                        <p style="line-height: 10px; font-size: 100%">Americana</p>
                    </div>
                    <div class="col-md-8">
                        <p style="line-height: 22px; font-size: 170%"><strong>Prefeitura Municipal de Americana</strong></p>
                        <p style="line-height: 22px; font-size: 170%"><strong>Estado de São Paulo</strong></p>
                        <p style="line-height: 22px; font-size: 170%"><strong>Unidade de Avaliação e Auditoria</strong></p>
                        <p style="line-height: 20px; font-size: 150%"><strong>Produção Geral - Por Prestador</strong></p> 
                    </div>
                    <div class="col-md-2">
                        <br>
                        <br>
                        <br>
                        <br>
                        <p style="line-height: 15px; font-size: 120%"><strong><?php echo substr($mesano, 0, 4)."/".substr($mesano, 4, 2) ?></strong></p>
                    </div>
                </div>
                
            </div>
        </section>
        
                        
          <?php
          $DcRub="00";
          $DcCnes="0000000";
          /** Soma Grupo*/
          $gr="00";
          $SgQtp = 0;
          $SgVlP = 0.00;
          $SgQtA = 0;
          $SgVlA = 0.00;
          /** Soma SubGrupo*/
          $sgr="00";
          $SsQtp = 0;
          $SsVlP = 0.00;
          $SsQtA = 0;
          $SsVlA = 0.00;
          /** Soma Forma*/
          $fr="000000";
          $SfQtp = 0;
          $SfVlP = 0.00;
          $SfQtA = 0;
          $SfVlA = 0.00;
          /** Soma Tipo */
          $StQtp = 0;
          $StVlP = 0.00;
          $StQtA = 0;
          $StVlA = 0.00;
          /** Soma Prestador */
          $SpQtp = 0;
          $SpVlP = 0.00;
          $SpQtA = 0;
          $SpVlA = 0.00;

/*********************************************************************************/                             
/******  Início de Leitura do Banco de Dados
/*********************************************************************************/                             
                             
        foreach ($readRels->getResult() as $rel): 
            
            /** Total Grupo */
            if($SgQtA<>0 && $gr <> $rel["GRUPO"]){
              echo "<tr>";
              echo "<td> </td>";
              echo "<td align=right><b>Soma do Grupo </b></td>";
              echo "<td align=right> </td>";
              echo "<td align=right><b>".number_format($SgQtp,0, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($SgVlP,2, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($SgQtA,0, ',','.')."</b></td>";
              echo "<td align=right><b>" . number_format($SgVlA, 2, ',', '.') . "</b></td>";
              echo "</tr>";
              $SgQtp = 0;
              $SgVlP = 0.00;
              $SgQtA = 0;
              $SgVlA = 0.00;
            }
            
            /** Total Sub-Grupo */
            if($SsQtA<>0 && $sgr <> $rel["SUBGRUPO"]){
              echo "<tr>";
              echo "<td> </td>";
              echo "<td align=right><b>Soma do Sub-Grupo </b></td>";
              echo "<td align=right> </td>";
              echo "<td align=right><b>".number_format($SsQtp,0, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($SsVlP,2, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($SsQtA,0, ',','.')."</b></td>";
              echo "<td align=right><b>" . number_format($SsVlA, 2, ',', '.') . "</b></td>";
              echo "</tr>";
              $SsQtp = 0;
              $SsVlP = 0.00;
              $SsQtA = 0;
              $SsVlA = 0.00;
            }
                        
            /** Total Forma */
            if($SfQtA<>0 && $fr <> $rel["FORMA"]){
              echo "<tr>";
              echo "<td> </td>";
              echo "<td align=right><b>Soma da Forma de Organização </b></td>";
              echo "<td align=right> </td>";
              echo "<td align=right><b>".number_format($SfQtp,0, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($SfVlP,2, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($SfQtA,0, ',','.')."</b></td>";
              echo "<td align=right><b>" . number_format($SfVlA, 2, ',', '.') . "</b></td>";
              echo "</tr>";
              $SfQtp = 0;
              $SfVlP = 0.00;
              $SfQtA = 0;
              $SfVlA = 0.00;
            }

            /** Total Tipo */
            if($StQtA<>0 && $DcRub <> $rel["PRD_RUB"]){
              echo "<tr>";
              echo "<td> </td>";
              echo "<td align=right><b>Soma do Tipo</b></td>";
              echo "<td align=right> </td>";
              echo "<td align=right><b>".number_format($StQtp,0, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($StVlP,2, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($StQtA,0, ',','.')."</b></td>";
              echo "<td align=right><b>" . number_format($StVlA, 2, ',', '.') . "</b></td>";
              echo "</tr>";
              $StQtp = 0;
              $StVlP = 0.00;
              $StQtA = 0;
              $StVlA = 0.00;
            }

            /** Total Prestador */
            if($SpQtA<>0 && $DcCnes <> $rel["PRD_UID"]){
              echo "<tr>";
              echo "<td> </td>";
              echo "<td align=right><b>Soma do Prestador</b></td>";
              echo "<td align=right> </td>";
              echo "<td align=right><b>".number_format($SpQtp,0, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($SpVlP,2, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($SpQtA,0, ',','.')."</b></td>";
              echo "<td align=right><b>" . number_format($SpVlA, 2, ',', '.') . "</b></td>";
              echo "</tr>";
                
              echo "</tbody>";
              echo "</table>";

              $SpQtp = 0;
              $SpVlP = 0.00;
              $SpQtA = 0;
              $SpVlA = 0.00;
            }
                             
            /** Cabeçalho do Prestador */
            if($DcCnes <> $rel["PRD_UID"]){
                $DcCnes = $rel["PRD_UID"];
                
                echo "<table class='table table-condensed table-hover' style='page-break-before: always;'>";
                echo "<thead>";

                echo "<tr class='Unidade'>";
                echo "<th colspan='8'><h2>Prestador: ".$rel["PRD_UID"]." - ".$rel["UNIDADE"]."</h2></th>";
                echo "</tr>";

                echo "<tr>";
                echo "<th><b>Proc.</b></td>";
                echo "<th><b>Descrição</b></td>";
                echo "<th><b>Vl Un.</b></td>";
                echo "<th align=right><b>Qtd Apre</b></th>";
                echo "<th align=right><b>Val Apre</b></th>";
                echo "<th align=right><b>Qtd Apro</b></th>";
                echo "<th align=right><b>Val Apro</b></th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                
            } 
              
            if($DcRub <> $rel["PRD_RUB"]){
              $DcRub=$rel["PRD_RUB"];
              echo "<tr class='Financiamento'>";
              
                if(substr($rel["PRD_RUB"],0,2)<>"04"){
                  echo "<td colspan='8'><h4>Financiamento: ".$rub[array_search($rel["PRD_RUB"], array_column($rub,"ID"))]["DC"]."</h4></td>";
                }else {
                  echo "<td colspan='8'><h4>Financiamento: Fundo de Ações Estrategicas e Compensacão: ".$rub[array_search($rel["PRD_RUB"], array_column($rub,"ID"))]["DC"]."</h4></td>";  
                }
              echo "</tr>";  
            }
            
            if($gr <> $rel["GRUPO"]){
                $gr=$rel["GRUPO"];
                echo "<tr class='Grupo'>";
                echo "<td colspan='8'><b>Grupo: ".$grupo[array_search($rel["GRUPO"], array_column($grupo,"GRUPO_ID"))]["nome"]."</b></td>";
                echo "</tr>";
            }
                            
            if($sgr <> $rel["SUBGRUPO"]){
                $sgr=$rel["SUBGRUPO"];
                echo "<tr class='Forma'>";
                echo "<td colspan='8'><b>Sub-Grupo: ".$grupo[array_search($rel["SUBGRUPO"], array_column($grupo,"GRUPO_ID"))]["nome"]."</b></td>";
                echo "</tr>";
            }
                            
            if($fr <> $rel["FORMA"]){
                $fr=$rel["FORMA"];
                echo "<tr class='Forma'>";
                echo "<td colspan='8'><b>Organização: ".$grupo[array_search($rel["FORMA"], array_column($grupo,"GRUPO_ID"))]["nome"]."</b></td>";
                echo "</tr>";
            }
                            
              echo "<tr>";
              echo "<td>".$rel["PRD_PA"]."</td>";
              echo "<td>".substr($rel["PA_DC"],0,40)."</td>";
              echo "<td align=right>".number_format($rel["PA_TOTAL"],2, ',','.')."</td>";
              echo "<td align=right>".number_format($rel["PRD_QT_P"],0, ',','.')."</td>";
              echo "<td align=right>".number_format($rel["PRD_VL_P"],2, ',','.')."</td>";
              echo "<td align=right>".number_format($rel["PRD_QT_A"],0, ',','.')."</td>";
              echo "<td align=right>".number_format($rel["PRD_VL_A"],2, ',','.')."</td>";
              echo "</tr>";
          
          $StQtp += $rel["PRD_QT_P"];
          $StVlP += $rel["PRD_VL_P"];
          $StQtA += $rel["PRD_QT_A"];
          $StVlA += $rel["PRD_VL_A"];
          
          $SpQtp += $rel["PRD_QT_P"];
          $SpVlP += $rel["PRD_VL_P"];
          $SpQtA += $rel["PRD_QT_A"];
          $SpVlA += $rel["PRD_VL_A"];
          
          $SgQtp += $rel["PRD_QT_P"];
          $SgVlP += $rel["PRD_VL_P"];
          $SgQtA += $rel["PRD_QT_A"];
          $SgVlA += $rel["PRD_VL_A"];
          
          $SsQtp += $rel["PRD_QT_P"];
          $SsVlP += $rel["PRD_VL_P"];
          $SsQtA += $rel["PRD_QT_A"];
          $SsVlA += $rel["PRD_VL_A"];
                    
          $SfQtp += $rel["PRD_QT_P"];
          $SfVlP += $rel["PRD_VL_P"];
          $SfQtA += $rel["PRD_QT_A"];
          $SfVlA += $rel["PRD_VL_A"];
              
          endforeach; 

/*********************************************************************************/                             
/******  FIM de Leitura do Banco de Dados
/*********************************************************************************/                             
          
            /** Total Grupo Fim do Relatório */
            if($SgQtA<>0){
              echo "<tr>";
              echo "<td> </td>";
              echo "<td align=right><b>Soma do Grupo</b></td>";
              echo "<td align=right> </td>";
              echo "<td align=right><b>".number_format($SgQtp,0, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($SgVlP,2, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($SgQtA,0, ',','.')."</b></td>";
              echo "<td align=right><b>" . number_format($SgVlA, 2, ',', '.') . "</b></td>";
              echo "</tr>";
              $SgQtp = 0;
              $SgVlP = 0.00;
              $SgQtA = 0;
              $SgVlA = 0.00;
              $gr = $rel["GRUPO"];
            }
            
            /** Total Sub-Grupo Fim do Relatório */
            if($SsQtA<>0){
              echo "<tr>";
              echo "<td> </td>";
              echo "<td align=right><b>Soma do Sub-Grupo</b></td>";
              echo "<td align=right> </td>";
              echo "<td align=right><b>".number_format($SsQtp,0, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($SsVlP,2, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($SsQtA,0, ',','.')."</b></td>";
              echo "<td align=right><b>" . number_format($SsVlA, 2, ',', '.') . "</b></td>";
              echo "</tr>";
              $SsQtp = 0;
              $SsVlP = 0.00;
              $SsQtA = 0;
              $SsVlA = 0.00;
              $sgr = $rel["SUBGRUPO"];
            }
          
          /** Total Forma Fim do Relatório*/
            if($SfQtA<>0){
              echo "<tr>";
              echo "<td> </td>";
              echo "<td align=right><b>Soma da Forma de Organização</b></td>";
              echo "<td align=right> </td>";
              echo "<td align=right><b>".number_format($SfQtp,0, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($SfVlP,2, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($SfQtA,0, ',','.')."</b></td>";
              echo "<td align=right><b>" . number_format($SfVlA, 2, ',', '.') . "</b></td>";
              echo "</tr>";
              $SfQtp = 0;
              $SfVlP = 0.00;
              $SfQtA = 0;
              $SfVlA = 0.00;
              $fr = $rel["FORMA"];
            }

          
          /** Total Tipo Fim do Relatório */
            if($StQtA<>0){
              echo "<tr>";
              echo "<td> </td>";
              echo "<td align=right><b>Soma do Tipo</b></td>";
              echo "<td align=right> </td>";
              echo "<td align=right><b>".number_format($StQtp,0, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($StVlP,2, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($StQtA,0, ',','.')."</b></td>";
              echo "<td align=right><b>" . number_format($StVlA, 2, ',', '.') . "</b></td>";
              echo "</tr>";
              $StQtp = 0;
              $StVlP = 0.00;
              $StQtA = 0;
              $StVlA = 0.00;
            }

          /** Total Prestador Fim do Relatório*/
            if($SpQtA<>0 ){
              echo "<tr>";
              echo "<td> </td>";
              echo "<td align=right><b>Soma do Prestador</b></td>";
              echo "<td align=right> </td>";
              echo "<td align=right><b>".number_format($SpQtp,0, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($SpVlP,2, ',','.')."</b></td>";
              echo "<td align=right><b>".number_format($SpQtA,0, ',','.')."</b></td>";
              echo "<td align=right><b>" . number_format($SpVlA, 2, ',', '.') . "</b></td>";
              echo "</tr>";
              $SpQtp = 0;
              $SpVlP = 0.00;
              $SpQtA = 0;
              $SpVlA = 0.00;
            }
          
          ?>
            </tbody>
            </table>
            
            
        <?php endif; ?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>        