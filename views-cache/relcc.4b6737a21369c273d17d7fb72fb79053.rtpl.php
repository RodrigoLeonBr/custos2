<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Relatório de Custos
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li>Custos</li>
            <li class="active"><a href="/relcc">Relatório por Centro de Custo</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <?php if( $error != '' ){ ?>

            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

            </div>
            <?php } ?>

            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Escolher os Filtros Desejados</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/relcc" method="post">
                        <div class="row col-md-12">
                            <!-- Ano -->
                            <div class="form-group col-md-3">
                                <label>Ano :
                                    <select name="ano" class="form-control">
                                        <option value="null"> Selecione o Ano: </option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                    </select>
                                </label>
                            </div>
                            <!-- Mês -->
                            <div class="form-group col-md-3">
                                <label>Quadrimestre :
                                    <select name="mes" class="form-control">
                                        <option value="null"> Selecione o Quadrimestre: </option>
                                        <option value="1">Jan a Abr</option>
                                        <option value="5">Mai a Ago</option>
                                        <option value="9">Set a Dez</option>
                                    </select>
                                </label>
                            </div>
                            <!-- Centro de Custo -->
                            <div class="box-body">
                                <div class="form-group col-md-5">
                                    <label>Centro de Custo :
                                        <select name="id_CentroCusto" class="form-control">
                                            <option value="null">Centro de Custo: </option>
                                            <?php $counter1=-1;  if( isset($ccusto) && ( is_array($ccusto) || $ccusto instanceof Traversable ) && sizeof($ccusto) ) foreach( $ccusto as $key1 => $value1 ){ $counter1++; ?>

                                            <option value="<?php echo htmlspecialchars( $value1["idCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["DescCentroCusto"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                                            <?php } ?>

                                        </select>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <div class="form-group col-md-3">
                                <label>Unidade :
                                    <select name="id_Unidade" class="form-control">
                                        <option value="null"> Selecione a Unidade: </option>
                                        <?php $counter1=-1;  if( isset($unidade) && ( is_array($unidade) || $unidade instanceof Traversable ) && sizeof($unidade) ) foreach( $unidade as $key1 => $value1 ){ $counter1++; ?>

                                        <option value="<?php echo htmlspecialchars( $value1["idUnidade"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["UnDescricao"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                                        <?php } ?>

                                    </select>
                                </label>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Grupo :
                                    <select name="id_GrupoCC" class="form-control">
                                        <option value="null"> Selecione o Grupo: </option>
                                        <?php $counter1=-1;  if( isset($grupo) && ( is_array($grupo) || $grupo instanceof Traversable ) && sizeof($grupo) ) foreach( $grupo as $key1 => $value1 ){ $counter1++; ?>

                                        <option value="<?php echo htmlspecialchars( $value1["idGrupoCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["DescGrupoCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                                        <?php } ?>

                                    </select>
                                </label>
                            </div>
                            <div class="form-group col-md-3">
                                <label>SubGrupo :
                                    <select name="id_SubGrupoCC" class="form-control">
                                        <option value="null"> Selecione o Grupo: </option>
                                        <?php $counter1=-1;  if( isset($subgrupo) && ( is_array($subgrupo) || $subgrupo instanceof Traversable ) && sizeof($subgrupo) ) foreach( $subgrupo as $key1 => $value1 ){ $counter1++; ?>

                                        <option value="<?php echo htmlspecialchars( $value1["idSubGrupoCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["DescSubGrupoCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                                        <?php } ?>

                                    </select>
                                </label>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="row col-md-12">
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success">Exibir Relatório</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->