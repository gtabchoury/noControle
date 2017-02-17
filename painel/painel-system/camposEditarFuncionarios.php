<div class="row">
    <div class="form-group col-lg-5" align='left'>
        <label class="control-label">Nome</label>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-font"></i>
            </span>
            <input value="<?php echo"$nome";?>" type="text" name="nomeFuncionario" class="form-control" placeholder="Nome"
            required/>
        </div>
    </div>
    <div class="form-group col-lg-5" align='left'>
        <label class="control-label">Salário</label>
        <div class="input-group">
            <span class="input-group-addon">
                R$
            </span>
            <input value="<?php echo"$salario";?>" type="text" name="salarioFuncionario" class="form-control" placeholder="ex: 2720,75"
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
            <input value="<?php echo"$telefone";?>" type="text" name="telFuncionario" id="telefone" class="form-control" placeholder="Telefone" onkeyup="mascara( this, mtel );" maxlength="15"
            required/>
        </div>
    </div>
    <div class="form-group col-lg-5" align='left'>
        <label class="control-label">CPF</label>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-user"></i>
            </span>
            <input value="<?php echo"$cpf";?>" type="text" name="cpfFuncionario" class="form-control" placeholder="CPF" maxlength="14" OnKeyPress="formatar('###.###.###-##', this)"
            required/>
        </div>
    </div>                              
</div>
<br>
<div class="row">
    <div class="form-group col-lg-10" align='left'>
        <label class="control-label">Endereço</label>
        <br>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-home"></i>
            </span>
            <input value="<?php echo"$endereco2";?>" type="text" name="endFuncionario" id="endereco" class="form-control" placeholder="Ex: Rua das Palmeiras, 920 - Centro, Campinas - SP"/>
        </div>
    </div>                            
</div>