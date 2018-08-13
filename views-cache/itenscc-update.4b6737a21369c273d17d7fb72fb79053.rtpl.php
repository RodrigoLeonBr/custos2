<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Editar Item de Lançamento de Custos
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
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar Item de Lançamento de Custos</h3>
                    </div>
                    <!-- form start -->
                    <form role="form" action="/itenslanc/<?php echo htmlspecialchars( $itemcc["idItemCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
                        <?php if( $error != '' ){ ?>

                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

                        </div>
                        <?php } ?>

                        <!-- Descrição -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="DescItemCC">Nome do Item de Lançamento</label>
                                <input type="text" class="form-control" id="DescItemCC" name="DescItemCC" placeholder="Digite o item de lançamento" value="<?php echo htmlspecialchars( $itemcc["DescItemCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>
                        </div>
                        <!-- Conteúdo -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="ConteudoItemCC">Descrição do Conteúdo</label>
                                <textarea class="form-control" id="ConteudoItemCC" name="ConteudoItemCC" rows="5"  placeholder="Digite a descrição do centro de custo"><?php echo htmlspecialchars( $itemcc["ConteudoItemCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea>
                            </div>
                        </div>
                        <!-- Grupo e Ordem -->
                        <div class="box-body">
                            <div class="form-group col-md-4">
                                <label>Grupo do Item de Lançamento :
                                    <select name="id_GrupoItemCC" class="form-control">
                                        <option value="null"> Selecione o Grupo: </option>
                                        <?php $counter1=-1;  if( isset($grupoitem) && ( is_array($grupoitem) || $grupoitem instanceof Traversable ) && sizeof($grupoitem) ) foreach( $grupoitem as $key1 => $value1 ){ $counter1++; ?>

                                        <option value="<?php echo htmlspecialchars( $value1["idGrupoItemCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"
                                                <?php if( $itemcc["id_GrupoItemCC"] == $value1["idGrupoItemCC"] ){ ?>

                                                selected="selected"
                                                <?php } ?>

                                                ><?php echo htmlspecialchars( $value1["DescGrupoItemCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                                        <?php } ?>

                                    </select>
                                </label>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Ordem">Ordem de Exibição</label>
                                <input type="text" class="form-control" id="Ordem" name="Ordem" placeholder="Digite a ordem de exibição"  value="<?php echo htmlspecialchars( $itemcc["Ordem"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
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