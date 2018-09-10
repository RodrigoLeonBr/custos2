<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Editar Lançamento de Folha de Pagamento
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
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar Lançamento de Folha de Pagamento</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/folha/<?php echo htmlspecialchars( $folha["idFolha"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
                        <?php if( $error != '' ){ ?>

                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

                        </div>
                        <?php } ?>

                        <!-- Ano Mes Centro Custo -->
                        <div class="box-body">
                            <!-- Ano -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="Ano">Ano</label>
                                    <input type="text" class="form-control" id="Ano" name="Ano" placeholder="Ano" value="<?php echo htmlspecialchars( $folha["Ano"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                </div>
                            </div>
                            <!-- Mes -->
                            <div class="form-group col-md-3">
                                <div class="form-group">
                                    <label for="Mes">Mês</label>
                                    <input type="text" class="form-control" id="Mes" name="Mes" placeholder="Mes" value="<?php echo htmlspecialchars( $folha["Mes"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                </div>
                            </div>
                            <!-- Centro Custo -->
                            <div class="form-group col-md-6">
                                <label>C Custo:
                                    <select name="id_CentroCusto" class="form-control">
                                        <option value="null"> Selecione o Centro de Custo: </option>
                                        <?php $counter1=-1;  if( isset($ccusto) && ( is_array($ccusto) || $ccusto instanceof Traversable ) && sizeof($ccusto) ) foreach( $ccusto as $key1 => $value1 ){ $counter1++; ?>

                                        <?php if( $folha["id_CentroCusto"] == $value1["idCentroCusto"] ){ ?>

                                        <option value="<?php echo htmlspecialchars( $value1["idCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" selected="selected">
                                            <?php }else{ ?>

                                        <option value="<?php echo htmlspecialchars( $value1["idCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                            <?php } ?>

                                            <?php echo htmlspecialchars( $value1["DescCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                                        <?php } ?>

                                    </select>
                                </label>
                            </div>
                        </div>
                        <!-- CENTRO DE CUSTO ORIGINAL -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="CentroCusto">Nome do Centro de Custo ORIGINAL</label>
                                <input type="text" class="form-control" id="CentroCusto" name="CentroCusto" placeholder="Digite o nome do centro de custo ORIGINAL" value="<?php echo htmlspecialchars( $folha["CentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>
                        </div>
                        <!-- EVENTO ORIGINAL -->
                        <div class="box-body">
                            <!-- Evento -->
                            <div class="form-group col-md-4">
                                <label for="Evento">N. Evento</label>
                                <input type="text" class="form-control" id="Evento" name="Evento" placeholder="N Evento" value="<?php echo htmlspecialchars( $folha["Evento"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>
                            <!-- Descrição do Evento -->
                            <div class="form-group col-md-8">
                                <label for="Descricao">Descrição do Evento</label>
                                <input type="text" class="form-control" id="Descricao" name="Descricao" placeholder="Descrição do Evento" value="<?php echo htmlspecialchars( $folha["Descricao"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>
                        </div>
                        <!-- CCUSTO ORIGINAL, QTD Valor -->
                        <div class="box-body">
                            <!-- CCusto -->
                            <div class="form-group col-md-4">
                                <label for="Ccusto">C. Custo</label>
                                <input type="text" class="form-control" id="Ccusto" name="Ccusto" placeholder="C Custo Orig" value="<?php echo htmlspecialchars( $folha["Ccusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>
                            <!-- Qtd -->
                            <div class="form-group col-md-4">
                                <label for="Qtd">Qtd</label>
                                <input type="text" class="form-control" id="Qtd" name="Qtd" placeholder="Quant" value="<?php echo htmlspecialchars( $folha["Qtd"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>
                            <!-- Valor -->
                            <div class="form-group col-md-4">
                                <label for="Valor">Valor</label>
                                <input type="text" class="form-control" id="Valor" name="Valor" placeholder="Valor" value="<?php echo htmlspecialchars( $folha["Valor"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>
                        </div>

                        <!--ItemCC-->
                        <div class="box-body">
                            <label>Item de Centro de Custo:
                                <select name="id_ItemCC" class="form-control">
                                    <option value="null"> Selecione Ítem de C Custo: </option>
                                    <?php $counter1=-1;  if( isset($itemcc) && ( is_array($itemcc) || $itemcc instanceof Traversable ) && sizeof($itemcc) ) foreach( $itemcc as $key1 => $value1 ){ $counter1++; ?>

                                    <?php if( $folha["id_ItemCC"] == $value1["idItemCC"] ){ ?>

                                    <option value="<?php echo htmlspecialchars( $value1["idItemCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" selected="selected">
                                        <?php }else{ ?>

                                    <option value="<?php echo htmlspecialchars( $value1["idItemCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                        <?php } ?>

                                        <?php echo htmlspecialchars( $value1["DescItemCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                                    <?php } ?>

                                </select>
                            </label>
                        </div>

                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->