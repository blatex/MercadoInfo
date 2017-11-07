<?php
/* @var $produto Models\Produto */
$produto = $data['produto'];
?>
<h2>Nome: <?= $produto->getNome() ?></h2>
<p>Descrição: <?= nl2br($produto->getDescricao()) ?></p>
<p>Valor: <?= nl2br($produto->getValor()) ?></p>