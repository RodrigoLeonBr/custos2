<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cadastrar Novo Contrato
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Principal</a></li>
            <li class="active"><a href="/contratos">Contratos</a></li>
        </ol>
    </section>

    <script language="javascript">
        //-----------------------------------------------------
        //Funcao: MascaraMoeda
        //Sinopse: Mascara de preenchimento de moeda
        //Parametro:
        //   objTextBox : Objeto (TextBox)
        //   SeparadorMilesimo : Caracter separador de milésimos
        //   SeparadorDecimal : Caracter separador de decimais
        //   e : Evento
        //Retorno: Booleano
        //Autor: Gabriel Fróes - www.codigofonte.com.br
        //-----------------------------------------------------
        function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e) {
            var sep = 0;
            var key = '';
            var i = j = 0;
            var len = len2 = 0;
            var strCheck = '0123456789';
            var aux = aux2 = '';
            var whichCode = (window.Event) ? e.which : e.keyCode;
            if (whichCode == 13)
                return true;
            key = String.fromCharCode(whichCode); // Valor para o código da Chave
            if (strCheck.indexOf(key) == -1)
                return false; // Chave inválida
            len = objTextBox.value.length;
            for (i = 0; i < len; i++)
                if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal))
                    break;
            aux = '';
            for (; i < len; i++)
                if (strCheck.indexOf(objTextBox.value.charAt(i)) != -1)
                    aux += objTextBox.value.charAt(i);
            aux += key;
            len = aux.length;
            if (len == 0)
                objTextBox.value = '';
            if (len == 1)
                objTextBox.value = '0' + SeparadorDecimal + '0' + aux;
            if (len == 2)
                objTextBox.value = '0' + SeparadorDecimal + aux;
            if (len > 2) {
                aux2 = '';
                for (j = 0, i = len - 3; i >= 0; i--) {
                    if (j == 3) {
                        aux2 += SeparadorMilesimo;
                        j = 0;
                    }
                    aux2 += aux.charAt(i);
                    j++;
                }
                objTextBox.value = '';
                len2 = aux2.length;
                for (i = len2 - 1; i >= 0; i--)
                    objTextBox.value += aux2.charAt(i);
                objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
            }
            return false;
        }
    </script>


    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Novo Contrato</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="/contratos/create" method="post">
                        <?php if( $error != '' ){ ?>

                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

                        </div>
                        <?php } ?>


                        <div class="box-body">
                            <!-- Protocolo -->
                            <div class="form-group col-md-4">
                                <label>Protocolo:</label>
                                <input type="text" class="form-control" name="Contrato_Protocolo" />
                            </div>
                            <!-- CNES -->
                            <div class="form-group col-md-4">
                                <label>CNES:</label>
                                <input type="text" class="form-control" name="Contrato_Cnes" />
                            </div>

                            <!-- CNPJ -->
                            <div class="form-group col-md-4">
                                <label>CNPJ:</label>
                                <input type="text" class="form-control" name="Contrato_Cnpj"/>
                            </div>

                            <!-- Prestador -->
                            <div class="form-group">
                                <label>Prestador:</label>
                                <input type="text" class="form-control" name="Contrato_Prestador" />
                            </div>

                            <!-- Observação -->
                            <div class="form-group">
                                <label>Observação:</label>
                                <input type="text" class="form-control" name="Contrato_Obs" />
                            </div>

                            <!-- Histórico -->
                            <div class="form-group">
                                <label>Histórico:</label>
                                <textarea name="Contrato_Historico" class="form-control" rows="5"></textarea>
                            </div>

                            <!-- Objeto do Convênio -->
                            <div class="form-group">
                                <label>Objeto do Contrato/Covênio:</label>
                                <textarea name="Contrato_Objeto" class="form-control" rows="5"></textarea>
                            </div>

                            <!-- Data do Contrato -->
                            <div class="form-group col-md-5">
                                <label>Data Contrato:</label>
                                <input type="text" class="form-control" name="Contrato_Data" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                            </div>

                            <!-- Data de Vencimento -->
                            <div class="form-group col-md-5">
                                <label>Data Vencimento:</label>
                                <input type="text" class="form-control formData" name="Contrato_Vencimento" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                            </div>

                            <div class="form-group col-md-5">
                                <label>Valor:</label>
                                <input type="text" class="form-control left" name="Contrato_Valor" />
                            </div>

                            <div class="form-group col-md-5">
                                <label>Quantidade:</label>
                                <input type="text" class="form-control left" name="Contrato_Qtd" />
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