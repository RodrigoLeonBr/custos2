<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Criar Centro de Custo
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li>Cadastro</li>
            <li class="active"><a href="/ccustos">C Custo</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Novo Centro de Custo</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/ccustos/create" method="post">
                        <?php if( $error != '' ){ ?>

                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

                        </div>
                        <?php } ?>

                        <!-- C Custo -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="DescCentroCusto">Nome do Centro de Custo</label>
                                <input type="text" class="form-control" id="DescCentroCusto" name="DescCentroCusto" placeholder="Digite o nome do centro de custo">
                            </div>
                        </div>
                        <!-- Conteúdo -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="ConteudoCentroCusto">Descrição do Conteúdo</label>
                                <textarea class="form-control" id="ConteudoCentroCusto" name="ConteudoCentroCusto" rows="5"  placeholder="Digite a descrição do centro de custo"></textarea>
                            </div>
                        </div>
                        <!-- Unidade Grupo e Subgrupo -->
                        <div class="box-body">
                            <div class="form-group col-md-4">
                                <label>Unidade do Centro de Custo :
                                    <select name="id_Unidade" class="form-control">
                                        <option value="null"> Selecione a Unidade: </option>
                                        <?php $counter1=-1;  if( isset($unidade) && ( is_array($unidade) || $unidade instanceof Traversable ) && sizeof($unidade) ) foreach( $unidade as $key1 => $value1 ){ $counter1++; ?>

                                        <option value="<?php echo htmlspecialchars( $value1["idUnidade"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["UnDescricao"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                                        <?php } ?>

                                    </select>
                                </label>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Grupo  do Centro de Custo :
                                    <select name="id_GrupoCC" class="form-control">
                                        <option value="null"> Selecione o Grupo: </option>
                                        <?php $counter1=-1;  if( isset($grupo) && ( is_array($grupo) || $grupo instanceof Traversable ) && sizeof($grupo) ) foreach( $grupo as $key1 => $value1 ){ $counter1++; ?>

                                        <option value="<?php echo htmlspecialchars( $value1["idGrupoCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["DescGrupoCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                                        <?php } ?>

                                    </select>
                                </label>
                            </div>
                            <div class="form-group col-md-4">
                                <label>SubGrupo do Centro de Custo:                 
                                    <select name="id_SubGrupoCC" class="form-control">
                                        <option value="null"> Selecione o Grupo: </option>
                                        <?php $counter1=-1;  if( isset($subgrupo) && ( is_array($subgrupo) || $subgrupo instanceof Traversable ) && sizeof($subgrupo) ) foreach( $subgrupo as $key1 => $value1 ){ $counter1++; ?>

                                        <option value="<?php echo htmlspecialchars( $value1["idSubGrupoCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["DescSubGrupoCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                                        <?php } ?>

                                    </select>
                                </label>
                            </div>
                            <!--TIPO DE UNIDADE-->
                            <div class="form-group col-md-4">
                                <label>Tipo de Centro de Custo (Produção ou Apoio)
                                    <select name="TipoCC" class="form-control">
                                        <option value="P">Produção</option>
                                        <option value="P">Apoio</option>
                                    </select>
                                </label>
                            </div>
                            <!--STATUS ATIVO OU INATIVO-->
                            <div class="form-group col-md-5">
                                <label>Status do Centro de Custo (Ativo ou Inativo)
                                    <select name="StatusCC" class="form-control">
                                        <option value="1">Ativo</option>
                                        <option value="0">Inativo</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->