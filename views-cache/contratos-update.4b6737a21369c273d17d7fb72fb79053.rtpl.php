<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Editar Contratos
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li><a href="/grupositem"></a>Contratos</li>
            <li class="active">Editar Contratos</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar Contratos</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/contratos/<?php echo htmlspecialchars( $contrato["idContrato"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
                        <?php if( $error != '' ){ ?>

                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

                        </div>
                        <?php } ?>

                        <!-- Protocolo -->
                        <div class="box-body">
                            <div class="form-group col-md-4">
                                <label>Protocolo:</label>
                                <input type="text" class="form-control" name="Contrato_Protocolo" value="<?php echo htmlspecialchars( $contrato["Contrato_Protocolo"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>
                            <!-- CNES -->
                            <div class="form-group col-md-4">
                                <label>CNES:</label>
                                <input type="text" class="form-control" name="Contrato_Cnes" value="<?php echo htmlspecialchars( $contrato["Contrato_Cnes"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>
                            <!-- CNPJ -->
                            <div class="form-group col-md-4">
                                <label>CNPJ:</label>
                                <input type="text" class="form-control" name="Contrato_Cnpj" value="<?php echo htmlspecialchars( $contrato["Contrato_Cnpj"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>

                            <!-- Prestador -->
                            <div class="form-group">
                                <label>Prestador:</label>
                                <input type="text" class="form-control" name="Contrato_Prestador"  value="<?php echo htmlspecialchars( $contrato["Contrato_Prestador"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>


                            <!-- Observação -->
                            <div class="form-group">
                                <label>Observação:</label>
                                <input type="text" class="form-control" name="Contrato_Obs" value="<?php echo htmlspecialchars( $contrato["Contrato_Obs"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>

                            <!-- Histórico -->
                            <div class="form-group">
                                <label>Histórico:</label>
                                <textarea name="Contrato_Historico" class="form-control" rows="5"><?php echo htmlspecialchars( $contrato["Contrato_Historico"], ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea>
                            </div>

                            <!-- Objeto do Convênio -->
                            <div class="form-group">
                                <label>Objeto do Contrato/Covênio:</label>
                                <textarea name="Contrato_Objeto" class="form-control" rows="5"><?php echo htmlspecialchars( $contrato["Contrato_Objeto"], ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea>
                            </div>

                            <!-- Data do Contrato -->
                            <div class="form-group col-md-5">
                                <label>Data Contrato:</label>
                                <input type="text" class="form-control" name="Contrato_Data" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?php echo htmlspecialchars( $contrato["Contrato_Data"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>

                            <!-- Data de Vencimento -->
                            <div class="form-group col-md-5">
                                <label>Data Vencimento:</label>
                                <input type="text" class="form-control formData" name="Contrato_Vencimento" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?php echo htmlspecialchars( $contrato["Contrato_Vencimento"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>

                            <div class="form-group col-md-5">
                                <label>Valor:</label>
                                <input type="text" class="form-control left" name="Contrato_Valor" value="<?php echo htmlspecialchars( $contrato["Contrato_Valor"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>

                            <div class="form-group col-md-5">
                                <label>Quantidade:</label>
                                <input type="text" class="form-control left" name="Contrato_Qtd" value="<?php echo htmlspecialchars( $contrato["Contrato_Qtd"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>
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