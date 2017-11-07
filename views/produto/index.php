<?php foreach ($data['produtos'] as $produto): ?>
    <div class="item-produto">
        <a href="<?= Lib\App::getRouter()->getUrl('produto', 'ver', [$produto->getIdProduto()]) ?>"><?= $produto->getNome() ?></a><br/>
    </div>
<?php endforeach; ?>
