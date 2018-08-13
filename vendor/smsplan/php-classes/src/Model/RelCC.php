<?php

namespace SMSPlan\Model;

use SMSPlan\DB\Sql;
use SMSPlan\Model;

class RelCC extends Model {

    public static function ListCC($ano, $mesi, $cond = '') {

        $sql = new Sql();

        return $sql->select("SELECT sum(case when mes=:mesi then a.Valor else 0 end) Mes1,
                            sum(case when mes=:mesi+1 then a.Valor else 0 end) Mes2,
                            sum(case when mes=:mesi+2 then a.Valor else 0 end) Mes3,
                            sum(case when mes=:mesi+3 then a.Valor else 0 end) Mes4,
                            id_CentroCusto, b.id_Unidade, e.UnDescricao, b.DescCentroCusto,
                            c.Ordem OrdemGrupo, c.DescGrupoCC, b.id_GrupoCC,
                            d.Ordem OrdemSubGrupo, d.DescSubGrupoCC, b.id_subGrupoCC
                            FROM c_movcusto a
                            INNER JOIN c_tabcentrocusto b on idCentroCusto = id_CentroCusto
                            INNER JOIN c_tabgrupocc c on c.idGrupoCC = b.id_GrupoCC
                            INNER JOIN c_tabsubgrupocc d on d.idsubGrupoCC = b.id_subGrupoCC
                            INNER JOIN c_tabunidade e ON idUnidade = b.id_Unidade
                            WHERE Ano = :ano AND
                            Mes >= :mesi and Mes <= :mesi+3 " . $cond .
                        " GROUP BY b.id_Unidade, OrdemGrupo, b.id_GrupoCC, OrdemSubGrupo, b.id_subGrupoCC, id_CentroCusto
                            ORDER BY b.id_Unidade, OrdemGrupo, b.id_GrupoCC, OrdemSubGrupo, b.id_subGrupoCC, id_CentroCusto
                    ", array(
                    ":ano" => $ano,
                    ":mesi" => $mesi
        ));
    }

    public static function ListTotalCC($ano, $mesi, $cc) {

        $sql = new Sql();

        return $sql->select("SELECT sum(case when mes=:mesi then c_movcusto.Valor else 0 end) Mes1,
                            sum(case when mes=:mesi+1 then c_movcusto.Valor else 0 end) Mes2,
                            sum(case when mes=:mesi+2 then c_movcusto.Valor else 0 end) Mes3,
                            sum(case when mes=:mesi+3 then c_movcusto.Valor else 0 end) Mes4
                            FROM c_movcusto
                            WHERE Mes >= :mesi AND Mes <= :mesi+3 AND Ano = :ano
                            AND id_CentroCusto = :cc
                    ", array(
                    ":ano" => $ano,
                    ":mesi" => $mesi,
                    ":cc" => $cc
        ));
    }

    public static function ListGrupoCC($ano, $mesi, $cc) {

        $sql = new Sql();

        return $sql->select("SELECT sum(case when mes=:mesi then a.Valor else 0 end) Mes1,
                            sum(case when mes=:mesi+1 then a.Valor else 0 end) Mes2,
                            sum(case when mes=:mesi+2 then a.Valor else 0 end) Mes3,
                            sum(case when mes=:mesi+3 then a.Valor else 0 end) Mes4,
                            c.Ordem OrdemGrupo, c.idGrupoItemCC, c.DescGrupoItemCC, b.id_GrupoItemCC, b.Ordem OrdemItem
                            FROM c_movcusto a
                            INNER JOIN c_tabitemcc b ON idItemCC = a.id_ItemCC
                            INNER JOIN c_tabgrupoitemcc c ON idGrupoItemCC = b.id_GrupoItemCC
                            WHERE Ano = :ano AND Mes >=:mesi AND Mes <=:mesi+3
                            AND id_CentroCusto = :cc
                            GROUP BY c.DescGrupoItemCC
                            ORDER BY OrdemGrupo, OrdemItem, c.DescGrupoItemCC
                    ", array(
                    ":ano" => $ano,
                    ":mesi" => $mesi,
                    ":cc" => $cc
        ));
    }

    public static function ListGrupoDetCC($ano, $mesi, $cc, $grupo) {

        $sql = new Sql();

        return $sql->select("SELECT sum(case when mes=:mesi then Valor else 0 end) Mes1,
                            sum(case when mes=:mesi+1 then Valor else 0 end) Mes2,
                            sum(case when mes=:mesi+2 then Valor else 0 end) Mes3,
                            sum(case when mes=:mesi+3 then Valor else 0 end) Mes4,
                            a.id_ItemCC, c.Ordem OrdemGrupo, b.DescItemCC
                            FROM c_movcusto a
                            INNER JOIN c_tabitemcc b ON b.idItemCC=a.id_ItemCC
                            INNER JOIN c_tabgrupoitemcc c ON idGrupoItemCC = b.id_GrupoItemCC
                            WHERE Ano= :ano
                            AND mes >= :mesi AND mes<= :mesi+3
                            AND id_CentroCusto = :cc
                            AND c.idGrupoItemCC = :grupo
                            GROUP BY OrdemGrupo, a.id_ItemCC, b.DescItemCC
                    ", array(
                    ":ano" => $ano,
                    ":mesi" => $mesi,
                    ":cc" => $cc,
                    ":grupo" => $grupo
        ));
    }

}
