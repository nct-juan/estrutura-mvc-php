<?php

namespace lib;
use PDO;
use lib\ApplicationDB;

/******************************** Desenvolvido por Ivan Ferrer **********************************
Versão 1.0 - Conexão orientada à objeto - 2012 - São Paulo - SP - Brasil
************* Copyright © 2012 - Todos os direitos reservados (distribuição gratuita) ***********/

class Paginator {

var $conexao = null; // armazena a nossa conexao
var $conexaoBanco = null; // armazena a selecao do nosso banco
//querys
var $query;
var $ordem=null;
var $limite=null;
var $sql;
var $registros;
var $acao;
//PARA ATIVAR A URL AMIGÁVEL
var $ativaSEO=1;
var $total_registros=0;

/* ------------------CONEXAO -------------------- */
public function conecta() 
{$this->conexaoBanco = new ApplicationDB();}
    
public function desconecta() 
{$this->conexaoBanco = null;}

//FUNÇÃO QUE RECEBE A QUERY
public function query($sql)
{
    $this->sql = $sql;
    return $this->actQuery();
}

//FUNÇÃO DE URL AMIGÁVEL
public function seo($url,$seo)
{
    if($this->ativaSEO==1)
    return $seo;
    else
    return $url;
}

//PAGINAÇÃO DE DADOS
public function setPage($n_paginas,$url,$seourl,$url_pg)
{
$pagina = $url_pg; //addslashes(strip_tags(trim($_REQUEST["pagina"])));
if($pagina == "") 
{$pagina = 1;}
//define a qtde de registro por página
$max=$n_paginas;
//organiza paginação
$inicio = $pagina - 1;
$inicio = $max * $inicio;

$total_da_lista = $this->total();
$this->sql .=" OFFSET $inicio LIMIT $max";
$concat = $this->conexaoBanco->query($this->sql) or die("Erro na consulta!<br>Verifique a query executada:<br>");
$fetch = $concat->fetchAll(PDO::FETCH_OBJ);
$this->acao = $fetch;

if(strpos($url,"?")>0)
    $ligamento="&";
 else
    $ligamento="?";

if($max!=0)
{
    $pag="<ul  class=\"breadcrumb\">";
    // Calculando pagina anterior
    $menos = $pagina - 1;
    // Calculando pagina posterior
    $mais = $pagina + 1;
    $pgs = ceil($total_da_lista / $max);

if($pgs > 1 )
{
    if($menos >0)
        $pag.="<li> <a href=\"\" onclick='pagAjax(event, \"$menos\")' >&laquo; Anterior</a> </li>";

    if (($pagina-4) < 1 )
        $anterior = 1;
     else
        $anterior = $pagina-4;

    if (($pagina+4) > $pgs )
        $posterior = $pgs;
     else
        $posterior = $pagina + 4;

for($i=$anterior;$i <= $posterior; $i++)
    if($i != $pagina)
        $pag.=" <li><a href=\"\" onclick='pagAjax(event, \"$i\")'>$i</a></li>";
     else
        $pag.=" <li><strong >".$i."</strong></li>";
    if($mais <= $pgs)
        $pag.=" <li><a href=\"\" onclick='pagAjax(event, \"$mais\")' >Pr&oacute;xima &raquo;</a> </li>";
}
$pag.="</ul>";
}
return $pag;
}
//EXECUTA A QUERY DE MODO PRIVADO
private function actQuery()
{
    $conection = $this->conexaoBanco->query($this->sql) or die("Erro na consulta!<br>Verifique a query executada:<br>");
    $fetch = $conection->fetchAll(PDO::FETCH_OBJ);
    $this->acao = $fetch;
}
//FAZ A CONSULTA NO BANCO, CASO o $exibe=1, mostra resultados não encontrados em caso de nulo.
public function resultados($titulo="",$exibe=0)
{
    if(count($this->acao)==0 && $exibe==1)
     {echo $titulo;}
     else
     {
        $this->registros=$this->acao;
        return $this->registros;
     }
}
//EXIBE O TOTAL DE REGISTROS DA CONSULTA
public function total()
{
    $this->total_registros = count($this->acao);
    return $this->total_registros;
}

public function exibeRegistros(){

if($this->total()==1)
    return "Foi encotrado <strong>".$this->total()."</strong> registro.";
 else
    return "Foram encotrados <strong>".$this->total()."</strong> registros.";
}

}

?>

