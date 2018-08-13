<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Lista de Unidades
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li>Cadastro</li>
            <li class="active"><a href="/unidades">Unidades</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar Unidade</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/unidades/<?php echo htmlspecialchars( $unidade["idUnidade"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
                        <?php if( $error != '' ){ ?>

                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

                        </div>
                        <?php } ?>

                        <!-- Descrição -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="UnDescricao">Nome da Unidade</label>
                                <input type="text" class="form-control" id="UnDescricao" name="UnDescricao" placeholder="Digite o nome da unidade" value="<?php echo htmlspecialchars( $unidade["UnDescricao"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            </div>
                        </div>
                        <!-- Conteúdo -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="UnConteudo">Descrição do Conteúdo</label>
                                <textarea class="form-control" id="UnConteudo" name="UnConteudo" rows="5"  placeholder="Digite a descrição da unidade"><?php echo htmlspecialchars( $unidade["UnConteudo"], ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea>
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