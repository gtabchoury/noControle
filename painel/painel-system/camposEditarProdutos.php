<div class="row">
    <div class="form-group col-lg-6" align='left'>
        <label class="control-label">Descrição</label>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-font"></i>
            </span>
            <input type="text" name="nomeProduto" class="form-control" value="<?php echo "$nome";?>" placeholder="Descrição"
            required/>
        </div>
    </div>
    <div class="form-group col-lg-3" align='left'>
        <label class="control-label">Estoque</label>
        <div class="input-group">
            <span class="input-group-addon">
                Nº
            </span>
            <input type="text" name="estoqueProduto" class="form-control" value="<?php echo "$estoque";?>" placeholder="ex: 10"
            />
        </div>
    </div>                                  
</div>