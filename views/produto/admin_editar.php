<?php
    /* @var $produto Models\Produto */
    $produto = $data['produto'];
?>

<h3>Editar Página</h3>

<form method="POST" action="">
    <input type="hidden" name="idProduto" value="<?= $produto->getIdProduto() ?>"/>
    <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" value="<?= $produto->getNome() ?>" placeholder="Nome"/>    
    </div>
    
    <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea name="descricao" id="descricao" class="form-control" placeholder="Descrição"><?= $produto->getDescricao() ?></textarea>    
    </div>

    <div class="form-group">
        <label for="valor">Valor</label>
        <input type="number" step="0.01" min="0" name="valor" id="valor" placeholder="Valor" class="form-control" value="<?= $produto->getValor() ?>"/>
    </div>
    
    <div class="form-group">
        <input type="checkbox" name="disponivel" id="disponivel" <?= ($produto->getDisponivel() ? 'checked=""' : '') ?>/> 
        <label for="disponivel">Disponível</label>
    </div>
    
    <input type="submit" class="btn btn-success" value="Editar"/>
</form>
