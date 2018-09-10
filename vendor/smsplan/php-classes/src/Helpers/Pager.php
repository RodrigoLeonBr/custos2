<?php

namespace SMSPlan\Helpers;

use SMSPlan\Helpers\Pager;

/**
 * Pager.class [ HELPER ]
 * Realização a gestão e a paginação de resultados do sistema!
 *
 * @copyright (c) 2014, Robson V. Leite UPINSIDE TECNOLOGIA
 */
class Pager {

    /** DEFINE O PAGER */
    private $Page;
    private $Limit;
    private $Offset;

    /** DEFINE O PAGINATOR */
    private $Rows;
    private $Link;
    private $MaxLinks;
    private $First;
    private $Last;

    /** RENDERIZA O PAGINATOR */
    private $Paginator;

    /**
     * <b>Iniciar Paginação:</b> Defina o link onde a paginação será recuperada. Você ainda pode mudar os textos
     * do primeiro e último link de navegação e a quantidade de links exibidos (opcional)
     * @param STRING $Link = Ex: index.php?pagina&page=
     * @param STRING $First = Texto do link (Primeira Página)
     * @param STRING $Last = Texto do link (Última Página)
     * @param STRING $MaxLinks = Quantidade de links (5)
     */
    function __construct($Link, $Rows, $First = null, $Last = null, $MaxLinks = null) {
        $this->Link = (string) $Link;
        $this->Rows = (int) $Rows;
        $this->First = ( (string) $First ? $First : 'Primeira Página' );
        $this->Last = ( (string) $Last ? $Last : 'Última Página' );
        $this->MaxLinks = ( (int) $MaxLinks ? $MaxLinks : 5);
    }

    /**
     * <b>Executar Pager:</b> Informe o índice da URL que vai recuperar a navegação e o limite de resultados por página.
     * Você devere usar LIMIT getLimit() e OFFSET getOffset() na query que deseja paginar. A página atual está em getPage()
     * @param INT $Page = Recupere a página na URL
     * @param INT $Limit = Defina o LIMIT da consulta
     */
    public function ExePager($Page, $Limit) {
        $this->Page = ( (int) $Page ? $Page : 1 );
        $this->Limit = (int) $Limit;
        $this->Offset = ($this->Page * $this->Limit) - $this->Limit;
    }

    /**
     * <b>Retornar:</b> Caso informado uma page com número maior que os resultados, este método navega a paginação
     * em retorno até a página com resultados!
     * @return LOCATION = Retorna a página
     */
    public function ReturnPage() {
        if ($this->Page > 1):
            $nPage = $this->Page - 1;
            header("Location: {$this->Link}{$nPage}");
        endif;
    }

    /**
     * <b>Obter Página:</b> Retorna o número da página atualmente em foco pela URL. Pode ser usada para validar
     * a navegação da paginação!
     * @return INT = Retorna a página atual
     */
    public function getPage() {
        return $this->Page;
    }

    public function getFirst() {
        return $this->First;
    }

    public function getLats() {
        return $this->Last;
    }

    /**
     * <b>Limite por Página:</b> Retorna o limite de resultados por página da paginação. Deve ser usada na SQL que obtém
     * os resultados. Ex: LIMIT = getLimit();
     * @return INT = Limite de resultados
     */
    public function getLimit() {
        return $this->Limit;
    }

    public function getRows() {
        return $this->Rows;
    }

    /**
     * <b>Offset por Página:</b> Retorna o offset de resultados por página da paginação. Deve ser usada na SQL que obtém
     * os resultado. Ex: OFFSET = getLimit();
     * @return INT = Offset de resultados
     */
    public function getOffset() {
        return $this->Offset;
    }

    /**
     * <b>Executar Paginação:</b> Cria o menu de navegação de paginação dentro de uma lista não ordenada com a class paginator.
     * Informe o nome da tabela e condições caso exista. O resto é feito pelo método. Execute um <b>echo getPaginator();</b>
     * para exibir a paginação na view.
     * @param STRING $Tabela = Nome da tabela
     * @param STRING $Termos = Condição da seleção caso tenha
     * @param STRING $ParseString = Prepared Statements
     */
    //Cria a paginação de resultados
    public function ExePaginator() {

        $this->Paginator = [];

        if ($this->Rows > $this->Limit):
            $Paginas = ceil($this->Rows / $this->Limit);
            $MaxLinks = $this->MaxLinks;
            $status = "";

            if ($this->Page == 1) {
                $status = " disabled";
            }
            array_push($this->Paginator, [
                "title" => $this->getFirst(),
                "link" => $this->Link,
                "pagina" => '1',
                "status" => $status
            ]);

            if (($this->Page - $MaxLinks) > 2) {
                array_push($this->Paginator, [
                    "title" => '...',
                    "link" => $this->Link,
                    "pagina" => '1',
                    "status" => ' disabled'
                ]);
            }

            for ($iPag = $this->Page - $MaxLinks; $iPag <= $this->Page - 1; $iPag ++):
                if ($iPag > 1):
                    array_push($this->Paginator, [
                        "title" => $iPag,
                        "link" => $this->Link,
                        "pagina" => $iPag,
                        "status" => ""
                    ]);
                endif;
            endfor;

            array_push($this->Paginator, [
                "title" => $this->Page,
                "link" => $this->Link,
                "pagina" => $this->Page,
                "status" => " active"
            ]);

            for ($dPag = $this->Page + 1; $dPag <= $this->Page + $MaxLinks; $dPag ++):
                if ($dPag <= $Paginas):
                    array_push($this->Paginator, [
                        "title" => $dPag,
                        "link" => $this->Link,
                        "pagina" => $dPag,
                        "status" => ""
                    ]);
                endif;
            endfor;

            if (($this->Page + $MaxLinks) < $Paginas - 1) {
                array_push($this->Paginator, [
                    "title" => '...',
                    "link" => $this->Link,
                    "pagina" => $Paginas,
                    "status" => ' disabled'
                ]);
            }

            if ($this->Page == $Paginas) {
                $status = " disabled";
            } else {
                $status = " ";
            }
            array_push($this->Paginator, [
                "title" => $this->getLats(),
                "link" => $this->Link,
                "pagina" => $Paginas,
                "status" => $status
            ]);

        endif;
    }

    /**
     * <b>Exibir Paginação:</b> Retorna os links para a paginação de resultados. Deve ser usada com um echo para exibição.
     * Para formatar as classes são: ul.paginator, li a e li .active.
     * @return HTML = Paginação de resultados
     */
    public function getPaginator() {
        return $this->Paginator;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */
}
