<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Importa Folha de Pagamento
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li>Tab Aux</li>
            <li class="active"><a href="/importafolha">Importa Folha de Pagamento</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header">

                        <?php if( $error != '' ){ ?>

                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

                        </div>
                        <?php } ?>

                        <h3 class="box-title">Ordem das Colunas para Importação</h3>
                        <table border='1'>
                            <tr>
                                <td align = 'center'><b>A</b></td>
                                <td align = 'center'><b>B</b></td>
                                <td align = 'center'><b>C</b></td>
                                <td align = 'center'><b>D</b></td>
                                <td align = 'center'><b>E</b></td>
                                <td align = 'center'><b>F</b></td>
                                <td align = 'center'><b>G</b></td>
                                <td align = 'center'><b>H</b></td>
                            </tr>
                            <tr>
                                <td><b>Centro de Custo</b></td>
                                <td><b>Evento</b></td>
                                <td><b>Descrição</b></td>
                                <td><b>C.Custo</b></td>
                                <td><b>Qtde</b></td>
                                <td><b>Valor</b></td>
                                <td><b>Ano</b></td>
                                <td><b>Mês</b></td>
                            </tr>
                            <tr>
                                <td>Texto com o Centro de Custo</td>
                                <td>Código do Evento</td>
                                <td>Descrição do Evento</td>
                                <td>Código do C Custo</td>
                                <td>Quantide de ocorrencias</td>
                                <td>Valor Total do Evento</td>
                                <td>Ano do Evento</td>
                                <td>Mês do Evento</td>
                            </tr>
                        </table>

                        <h3>Somente serão processados as linhas correspondentes ao Ano e Mês assinalado</h3>

                        <div class="box box-default">
                            <form role="form" name="ImportaFolha" action="/importafolha" method="post" enctype="multipart/form-data">
                                <!-- MÊS ANO -->
                                <div class="form-group col-md-6">
                                    <label>Nome Importacao (Ano/Mes):</label>
                                    <input type="text" class="form-control" name="importa_tabela" value="" />
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Ano:</label>
                                    <input type="text" class="form-control" name="importa_ano" value="" />
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Mês:</label>
                                    <input type="text" class="form-control" name="importa_mes" value="" />
                                </div>
                                <!-- ESCOLHER ARQUIVO -->
                                <div class="form-group col-lg-6">
                                    <label>Enviar Folha de Pagamento:</label>
                                    <input type="file" name="importa_arquivo">
                                </div>
                                <div class="form-group col-md-3">
                                    <br>
                                    <input type="submit" class="btn btn-success" value="Importa Tabela" name="SendFolhaForm" />
                                </div>
                            </form>
                        </div>

                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-right">
                                <?php $counter1=-1;  if( isset($pages) && ( is_array($pages) || $pages instanceof Traversable ) && sizeof($pages) ) foreach( $pages as $key1 => $value1 ){ $counter1++; ?>

                                <li class="page-item <?php echo htmlspecialchars( $value1["status"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><a title = "<?php echo htmlspecialchars( $value1["title"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" href="<?php echo htmlspecialchars( $value1["link"], ENT_COMPAT, 'UTF-8', FALSE ); ?><?php echo htmlspecialchars( $value1["pagina"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["title"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                                <?php } ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->