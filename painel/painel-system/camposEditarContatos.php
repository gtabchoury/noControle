<div class="row">
    <div class="form-group col-lg-5" align='left'>
        <label class="control-label">Nome</label>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-font"></i>
            </span>
            <input value="<?php echo"$nome";?>" type="text" name="nomeContato" class="form-control" placeholder="Nome"
            required/>
        </div>
    </div>
    <div class="form-group col-lg-5" align='left'>
        <label class="control-label">E-mail</label>
        <div class="input-group">
            <span class="input-group-addon">
                @
            </span>
            <input value="<?php echo"$email";?>" type="text" name="emailContato" class="form-control" placeholder="E-mail"
            required/>
        </div>
    </div>                                  
</div>
<br>
<div class="row">
    <div class="form-group col-lg-5" align='left'>
        <label class="control-label">Telefone</label>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-phone"></i>
            </span>
            <input value="<?php echo"$telefone";?>" type="text" name="telContato" id="telefone" class="form-control" placeholder="Telefone" onkeyup="mascara( this, mtel );" maxlength="15"
            required/>
        </div>
    </div>
    <div class="form-group col-lg-5" align='left'>
        <label class="control-label">CPF</label>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-user"></i>
            </span>
            <input value="<?php echo"$cpf";?>" type="text" name="cpfContato" class="form-control" placeholder="CPF" maxlength="14" OnKeyPress="formatar('###.###.###-##', this)"
            required/>
        </div>
    </div>                              
</div>