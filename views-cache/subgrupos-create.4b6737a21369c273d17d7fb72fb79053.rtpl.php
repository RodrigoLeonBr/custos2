<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Lista de SubGrupos
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li>Cadastro</li>
            <li class="active"><a href="/subgrupos">SubGrupos</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Novo SubGrupo</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/subgrupos/create" method="post">
                        <?php if( $error != '' ){ ?>

                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

                        </div>
                        <?php } ?>

                        <!-- SubGrupo -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="DescSubGrupoCC">Nome do SubGrupo</label>
                                <input type="text" class="form-control" id="DescSubGrupoCC" name="DescSubGrupoCC" placeholder="Digite o nome do subgrupo">
                            </div>
                        </div>
                        <!-- Conteúdo -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="SubGrupoConteudo">Descrição do SubGrupo</label>
                                <textarea class="form-control" id="SubGrupoConteudo" name="SubGrupoConteudo" rows="5"  placeholder="Digite a descrição do subgrupo"></textarea>
                            </div>
                        </div>
                        <!-- Ordem -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="Ordem">Ordem de Exibição do SubGrupo</label>
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