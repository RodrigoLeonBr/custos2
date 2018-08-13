<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Centros de Custo da Unidade <?php echo htmlspecialchars( $unidade["UnDescricao"], ENT_COMPAT, 'UTF-8', FALSE ); ?>

        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li> Cadastro</li>
            <li><a href="/unidades">Unidades</a></li>
            <li><a href="/unidades/<?php echo htmlspecialchars( $unidade["idUnidade"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/ccustos"><?php echo htmlspecialchars( $unidade["UnDescricao"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Todos os C Custos</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <table id="ccustosNotRelated" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">N.</th>
                                    <th>Nome do C Custo</th>
                                    <th style="width: 240px">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter1=-1;  if( isset($ccustosNotRelated) && ( is_array($ccustosNotRelated) || $ccustosNotRelated instanceof Traversable ) && sizeof($ccustosNotRelated) ) foreach( $ccustosNotRelated as $key1 => $value1 ){ $counter1++; ?>

                                <tr>
                                    <td><?php echo htmlspecialchars( $value1["idCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                    <td><?php echo htmlspecialchars( $value1["DescCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                    <td>
                                        <a href="/unidades/<?php echo htmlspecialchars( $unidade["idUnidade"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/ccustos/<?php echo htmlspecialchars( $value1["idCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/add" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>
                                    </td>
                                </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">C Custos na Unidade <?php echo htmlspecialchars( $unidade["UnDescricao"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">N.</th>
                                    <th>Nome do C Custo</th>
                                    <th style="width: 240px">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter1=-1;  if( isset($ccustosRelated) && ( is_array($ccustosRelated) || $ccustosRelated instanceof Traversable ) && sizeof($ccustosRelated) ) foreach( $ccustosRelated as $key1 => $value1 ){ $counter1++; ?>

                                <tr>
                                    <td><?php echo htmlspecialchars( $value1["idCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                    <td><?php echo htmlspecialchars( $value1["DescCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                    <td>
                                        <a href="/ccustos/<?php echo htmlspecialchars( $value1["idCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-left"></i> Editar</a>
                                    </td>
                                </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->