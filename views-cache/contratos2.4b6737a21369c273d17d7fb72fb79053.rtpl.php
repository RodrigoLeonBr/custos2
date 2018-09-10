<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Lista de Contratos
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li>Contratos</li>
            <li class="active"><a href="/contratos">Contratos</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header">
                        <a href="/contratos/create" class="btn btn-success">Cadastrar Contratos</a>
                        <?php if( $error != '' ){ ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>
                        </div>
                        <?php } ?>

                        <div class="box-tools">
                            <form action="/contratos">
                                <div class="input-group input-group-sm" style="width: 180px;">
                                <select name="status" class="form-control">
                                    <option value="1" selected="selected">Contratos Ativos</option>
                                    <option value="0">Contratos Inativos</option>
                                    <option value="2">Todos os Contratos</option>
                                </select>
                                </div>
                                <div class="input-group input-group-sm" style="width: 180px;">
                                    <input type="text" name="search" class="form-control pull-right" placeholder="Procurar" value="<?php echo htmlspecialchars( $search, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="box-body no-padding">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Protocolo</th>
                                    <th>Prestador</th>
                                    <th>Saldos</th>                                    
                                    <th style="width: 240px">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter1=-1;  if( isset($contrato) && ( is_array($contrato) || $contrato instanceof Traversable ) && sizeof($contrato) ) foreach( $contrato as $key1 => $value1 ){ $counter1++; ?>
                                <tr class="<?php if( $value1["DifVenc"] <0 ){ ?> bg-red color-palette <?php } ?>
                          <?php if( $value1["DifVenc"] >=0 && $value1["DifVenc"] <3 ){ ?>  bg-danger <?php } ?>
                          <?php if( $value1["DifVenc"] >=3 && $value1["DifVenc"] <=5 ){ ?> bg-warning <?php } ?>
                          <?php if( $value1["DifVenc"] >5 ){ ?> bg-default <?php } ?>
                          ">
                                    <td><?php echo htmlspecialchars( $value1["Contrato_Protocolo"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                    <td><?php echo htmlspecialchars( $value1["Contrato_Prestador"], ENT_COMPAT, 'UTF-8', FALSE ); ?>(<?php echo htmlspecialchars( $value1["lanc"], ENT_COMPAT, 'UTF-8', FALSE ); ?> lançamento(s))<br><b>CNES: </b><?php echo htmlspecialchars( $value1["Contrato_Cnes"], ENT_COMPAT, 'UTF-8', FALSE ); ?>&nbsp;<b> Dt. Ass.: </b><?php echo htmlspecialchars( $value1["Contrato_Data"], ENT_COMPAT, 'UTF-8', FALSE ); ?>&ensp;<b> Dt. Venc: </b><?php echo htmlspecialchars( $value1["Contrato_Vencimento"], ENT_COMPAT, 'UTF-8', FALSE ); ?>&ensp;<b><span style="font-size: 115%;"> Mês Venc.: <?php echo htmlspecialchars( $value1["DifVenc"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span></b><br><b>Obs.:</b><?php echo htmlspecialchars( $value1["Obs"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                    <td><b>Valor: </b><?php echo formatValor($value1["Contrato_Saldovalor"]); ?> <br><b>Qtd: </b><?php echo formatValor($value1["Contrato_Saldoqtd"]); ?></td>
                                    <td>
                                        <a href="/contratos/<?php echo htmlspecialchars( $value1["idContrato"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/itens" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Lanc</a>
                                        <a href="/contratos/<?php echo htmlspecialchars( $value1["idContrato"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="/contratos/<?php echo htmlspecialchars( $value1["idContrato"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" onclick="return confirm('Deseja realmente excluir este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Exc</a>
                                        <?php if( $value1["Contrato_Status"] < 1 ){ ?>
                                        <a href="/contratos/<?php echo htmlspecialchars( $value1["idContrato"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/active" class="btn btn-success btn-xs"><i class="fa fa-check"></i>&nbsp;</a>
                                        <?php }else{ ?>
                                        <a href="/contratos/<?php echo htmlspecialchars( $value1["idContrato"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/desactive" class="btn btn-warning btn-xs"><i class="fa fa-close"></i>&nbsp;</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
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