<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Lançamento de Folha de Pagamento
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li>Tab Aux</li>
            <li class="active"><a href="/folha">Folha Pag.</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header">
                        <a href="/folha/create" class="btn btn-success">Cadastrar Lançamento de Folha de Pagamento</a>
                        <?php if( $error != '' ){ ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>
                        </div>
                        <?php } ?>

                        <div class="box box-default">
                            <form role="form" action="/folha">
                                <div class="box-body">
                                    <div class="form-group col-md-2">
                                        <label for="Ano">Ano</label>
                                        <input type="text" class="form-control" id="Ano" name="Ano" placeholder="Ano" value="<?php echo htmlspecialchars( $Ano, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="Mes">Mes</label>
                                        <input type="text" class="form-control" id="Mes" name="Mes" placeholder="Mes" value="<?php echo htmlspecialchars( $Mes, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="CC">Centro Custo</label>
                                        <select name="CC" class="form-control">
                                            <?php $counter1=-1;  if( isset($CentroCusto) && ( is_array($CentroCusto) || $CentroCusto instanceof Traversable ) && sizeof($CentroCusto) ) foreach( $CentroCusto as $key1 => $value1 ){ $counter1++; ?>
                                            <option value="<?php echo htmlspecialchars( $value1["idCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["DescCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="search">Texto</label>
                                        <input type="text" name="search" class="form-control pull-right" placeholder="Procurar" value="<?php echo htmlspecialchars( $search, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                    </div>
                                    <div class="input-group-btn">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="box-body no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Ano-CC</th>
                                <th>Centro de Custo</th>
                                <th>Evento</th>
                                <th>Descrção</th>
                                <th>Qtd</th>
                                <th>Valor</th>
                                <th>Item</th>
                                <th style="width: 70px">&nbsp;</th>
                            </tr>


                            <?php $counter1=-1;  if( isset($folha) && ( is_array($folha) || $folha instanceof Traversable ) && sizeof($folha) ) foreach( $folha as $key1 => $value1 ){ $counter1++; ?>
                            <tr>
                                <td><?php echo htmlspecialchars( $value1["Ano"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $value1["Mes"], ENT_COMPAT, 'UTF-8', FALSE ); ?>-<?php echo htmlspecialchars( $value1["id_CentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["CentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["Evento"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["Descricao"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["Qtd"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["Valor"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["DescItemCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td>
                                    <a href="/folha/<?php echo htmlspecialchars( $value1["idFolha"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>&nbsp;</a>
                                    <a href="/folha/<?php echo htmlspecialchars( $value1["idFolha"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" onclick="return confirm('Deseja realmente excluir este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>&nbsp;</a>
                                </td>
                            </tr>
                            <?php } ?>

                        </table>
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

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->