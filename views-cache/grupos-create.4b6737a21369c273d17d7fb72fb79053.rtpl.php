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
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Novo Grupo</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/grupos/create" method="post">
                        <?php if( $error != '' ){ ?>

                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

                        </div>
                        <?php } ?>

                        <!-- Unidade -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="DescGrupoCC">Nome do Grupo</label>
                                <input type="text" class="form-control" id="DescGrupoCC" name="DescGrupoCC" placeholder="Digite o nome do grupo">
                            </div>
                        </div>
                        <!-- Conteúdo -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="GrupoConteudo">Descrição do Conteúdo</label>
                                <textarea class="form-control" id="GrupoConteudo" name="GrupoConteudo" rows="5"  placeholder="Digite a descrição do grupo"></textarea>
                            </div>
                        </div>
                        <!-- Ordem -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="Ordem">Ordem de Exibição do Grupo</label>
                                <input type="text" class="form-control" id="Ordem" name="Ordem" placeholder="Digite a ordem de exibição" value="<?php echo htmlspecialchars( $ordem["maxordem"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
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