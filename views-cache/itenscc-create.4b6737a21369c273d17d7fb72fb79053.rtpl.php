<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Criar Item de Lançamento de Custos
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li>Cadastro</li>
            <li class="active"><a href="/itenslanc">Item Lanc</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Novo Item de Lançamento de Custos</h3>
                    </div>
                    <!-- form start -->
                    <form role="form" action="/itenslanc/create" method="post">
                        <?php if( $error != '' ){ ?>

                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

                        </div>
                        <?php } ?>

                        <!-- Item de Lançamento -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="DescItemCC">Nome do Item de Lançamento</label>
                                <input type="text" class="form-control" id="DescItemCC" name="DescItemCC" placeholder="Digite o nome do item de lançamento">
                            </div>
                        </div>
                        <!-- Conteúdo -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="ConteudoItemCC">Descrição do Conteúdo</label>
                                <textarea class="form-control" id="ConteudoItemCC" name="ConteudoItemCC" rows="5"  placeholder="Digite a descrição do item de lançamento"></textarea>
                            </div>
                        </div>
                        <!-- Grupo e Ordem -->
                        <div class="box-body">
                            <div class="form-group col-md-4">
                                <label>Grupo do Item de Lançamento :
                                    <select name="id_GrupoItemCC" class="form-control">
                                        <option value="null"> Selecione o Grupo: </option>
                                        <?php $counter1=-1;  if( isset($grupoitem) && ( is_array($grupoitem) || $grupoitem instanceof Traversable ) && sizeof($grupoitem) ) foreach( $grupoitem as $key1 => $value1 ){ $counter1++; ?>

                                        <option value="<?php echo htmlspecialchars( $value1["idGrupoItemCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["DescGrupoItemCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                                        <?php } ?>

                                    </select>
                                </label>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Ordem">Ordem de Exibição</label>
                                <input type="text" class="form-control" id="Ordem" name="Ordem" placeholder="Digite a ordem de exibição">
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