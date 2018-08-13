<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Lista de Centros de Custos
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li>Cadastro</li>
            <li class="active"><a href="/ccustos">C Custos</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header">
                        <a href="/ccustos/create" class="btn btn-success">Cadastrar C Custos</a>
                        <?php if( $error != '' ){ ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>
                        </div>
                        <?php } ?>

                        <div class="box-tools">
                            <form action="/ccustos">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search" class="form-control pull-right" placeholder="Procurar" value="<?php echo htmlspecialchars( $search, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="box-body no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th style="width: 10px">N.</th>
                                <th>C Custo</th>
                                <th>Unidade</th>
                                <th>Grupo</th>
                                <th>SubGrupo</th>
                                <th>Tipo</th>
                                <th style="width: 120px">&nbsp;</th>
                            </tr>


                            <?php $counter1=-1;  if( isset($ccustos) && ( is_array($ccustos) || $ccustos instanceof Traversable ) && sizeof($ccustos) ) foreach( $ccustos as $key1 => $value1 ){ $counter1++; ?>
                            <?php if( $value1["StatusCC"] < 1 ){ ?>
                            <tr class="bg-danger">
                                <?php }else{ ?>
                            <tr>
                                <?php } ?>
                                <td><?php echo htmlspecialchars( $value1["idCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["DescCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["id_Unidade"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <?php echo htmlspecialchars( $value1["UnDescricao"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["id_GrupoCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <?php echo htmlspecialchars( $value1["DescGrupoCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["id_SubGrupoCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <?php echo htmlspecialchars( $value1["DescSubGrupoCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <?php if( $value1["TipoCC"] == 'P' ){ ?>
                                <td>Producao</td>
                                <?php }else{ ?>
                                <td>Apoio</td>
                                <?php } ?>
                                <td>
                                    <a href="/ccustos/<?php echo htmlspecialchars( $value1["idCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>&nbsp;</a>
                                    <a href="/ccustos/<?php echo htmlspecialchars( $value1["idCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" onclick="return confirm('Deseja realmente excluir este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>&nbsp;</a>
                                    <?php if( $value1["StatusCC"] < 1 ){ ?>
                                    <a href="/ccustos/<?php echo htmlspecialchars( $value1["idCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/active" class="btn btn-success btn-xs"><i class="fa fa-check"></i>&nbsp;</a>
                                    <?php }else{ ?>
                                    <a href="/ccustos/<?php echo htmlspecialchars( $value1["idCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/desactive" class="btn btn-warning btn-xs"><i class="fa fa-close"></i>&nbsp;</a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>

                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            <?php $counter1=-1;  if( isset($pages) && ( is_array($pages) || $pages instanceof Traversable ) && sizeof($pages) ) foreach( $pages as $key1 => $value1 ){ $counter1++; ?>
                            <li><a href="<?php echo htmlspecialchars( $value1["href"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["text"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->