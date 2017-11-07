<h3>Novo Produto</h3>

<form method="POST" action="">
    <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" value="" placeholder="Nome"/>    
    </div>
    
    <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea name="descricao" id="descricao" class="form-control" placeholder="Descrição"></textarea>    
    </div>
    
    <div class="form-group">
        <label for="valor">Valor</label>
        <input type="number" step="0.01" min="0" name="valor" id="valor" class="form-control" placeholder="Valor">
    </div>

    <div class="form-group">
        <input type="checkbox" name="disponivel" id="disponivel" checked=""/> 
        <label for="disponivel">Disponível</label>
    </div>

    
    <input type="submit" class="btn btn-success" value="Criar"/>
</form>
