<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Lista de Grupos
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li>Cadastro</li>
            <li class="active"><a href="/grupos">Grupos</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar Grupo</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/grupos/<?php echo htmlspecialchars( $grupo["idGrupoCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
                        <?php if( $error != '' ){ ?>

                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

                        </div>
                        <?php } ?>

                        <!-- Descrição -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="DescGrupoCC">Nome do Grupo</label>
                                <input type="text" class="form-control" id="DescGrupoCC" name="DescGrupoCC" placeholder="Digite o nome do grupo" value="<?php echo htmlspecialchars( $grupo["DescGrupoCC"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>
                        </div>
                        <!-- Conteúdo -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="GrupoConteudo">Descrição do Conteúdo</label>
                                <textarea class="form-control" id="GrupoConteudo" name="GrupoConteudo" rows="5"  placeholder="Digite a descrição do grupo"><?php echo htmlspecialchars( $grupo["GrupoConteudo"], ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea>
                            </div>
                        </div>
                        <!-- Ordem -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="Ordem">Ordem de Exibição do Grupo</label>
                                <input type="text" class="form-control" id="Ordem" name="Ordem" placeholder="Digite a ordem de exibição" value="<?php echo htmlspecialchars( $grupo["Ordem"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
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