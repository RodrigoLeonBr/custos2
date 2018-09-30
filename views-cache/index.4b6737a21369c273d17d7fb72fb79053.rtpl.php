<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Estatísticas da Secretaria de Saúde de Americana
        </h1>
        <ol class="breadcrumb">
            <li><a href="/custos2/"><i class="fa fa-dashboard"></i> Principal</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Estatística de Custos</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <!-- INDICADORES -->
                <div class="row">
                    <!-- MÊS INICIAL -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <div class="col-xs-2">
                                    <i class="fa fa-comments fa-4x"></i>
                                </div>
                                <div class="row text-right">
                                    <h3><?php echo htmlspecialchars( $Anoi, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo str_pad($Mesi,2,'0',STR_PAD_LEFT); ?>&nbsp;</h3>
                                    <p>Início Custo&nbsp;&nbsp;</p>
                                </div>
                            </div>
                            <a href="#" class="small-box-footer">Mais Detalhes <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- MÊS FINAL -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <div class="col-xs-2">
                                    <i class="fa fa-tasks fa-4x"></i>
                                </div>
                                <div class="row text-right">
                                    <h3><?php echo htmlspecialchars( $Anof, ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo str_pad($Mesf,2,'0',STR_PAD_LEFT); ?>&nbsp;</h3>
                                    <p>Fim Custo&nbsp;&nbsp;</p>
                                </div>
                            </div>
                            <a href="#" class="small-box-footer">Mais Detalhes <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- CUSTO ÚLTIMO MÊS -->
                    <div class="col-lg-5 col-md-5">
                        <div class="small-box bg-green">
                            <div class="inner">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-4x"></i>
                                </div>
                                <div class="row text-right">
                                    <h3><?php echo formatValor($ValCusto); ?>&nbsp;</h3>
                                    <p>Custo Último Mês&nbsp;&nbsp;</p>
                                </div>
                            </div>
                            <a href="#" class="small-box-footer">Mais Detalhes <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- SETORES -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-orange">
                            <div class="inner">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-4x"></i>
                                </div>
                                <div class="row text-right">
                                    <h3><?php echo number_format($Setores,0, ',','.'); ?>&nbsp;</h3>
                                    <p>Setores&nbsp;&nbsp;</p>
                                </div>
                            </div>
                            <a href="#" class="small-box-footer">Mais Detalhes <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- FUNCIONÁRIOS -->
                    <div class="col-lg-3 col-md-6">
                        <div class="small-box bg-orange">
                            <div class="inner">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-4x"></i>
                                </div>
                                <div class="row text-right">
                                    <h3><?php echo number_format($Funcionarios,0, ',','.'); ?>&nbsp;</h3>
                                    <p>Funcionários&nbsp;&nbsp;</p>
                                </div>
                            </div>
                            <a href="#" class="small-box-footer">Mais Detalhes <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ÍTENS DISPENSADOS -->
                    <div class="col-lg-5 col-md-5">
                        <div class="small-box bg-red">
                            <div class="inner">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-4x"></i>
                                </div>
                                <div class="row text-right">
                                    <h3><?php echo number_format($Itens,0, ',','.'); ?>&nbsp;</h3>
                                    <p>Ítens Dispensados&nbsp;&nbsp;</p>
                                </div>
                            </div>
                            <a href="#" class="small-box-footer">Mais Detalhes <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- FIM INDICADORES -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            Footer
        </div>
        <!-- /.box-footer-->
</div>
<!-- /.box -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
