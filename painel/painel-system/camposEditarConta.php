<div class="row">
    <div class="form-group col-lg-5" align="left">
        <label class="control-label">Nome</label>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-font"></i>
            </span>
            <input type="text" name="nomeConta" class="form-control" value="<?php echo"$nome";?>"
            required/>
        </div>
    </div>
    <div class="form-group col-lg-5" align="left">
        <label class="control-label">Número do Documento</label>
        <div class="input-group">
            <span class="input-group-addon">
                Nº
            </span>
            <input type="text" name="docConta" class="form-control" value="<?php echo"$doc";?>">
        </div>
    </div>                             
</div>
<br>
<div class="row">
    <div class="form-group col-lg-5" align="left">
        <label class="control-label">Valor</label>
        <div class="input-group">
            <span class="input-group-addon">
                R$
            </span>
            <input type="text" name="valorConta" class="form-control" value="<?php echo"$valor";?>" required>
        </div>
    </div>


    <div class="form-group col-lg-5" align="left">
        <label class="control-label">Data</label>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="date" name="dataConta" class="form-control" value="<?php echo"$data";?>" required>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="form-group col-lg-5" align="left">
        <div class="form-group">
            <label>Fonte</label>
            <select class="form-control chosen" name="fonteConta">             
                <option>Selecione o Contato</option>
                <?php
                for ($i=0;$i<$_SESSION['count'];$i++){
                    $nomeCont = $_SESSION['user_contatos'][$i];
                    $idCont = $_SESSION['user_contatos_ids'][$i];
                    if ($fonteID==$idCont){
                        echo "
                        <option value='$idCont' selected>
                            $nomeCont
                        </option>
                        ";
                    }else{
                        echo "
                        <option value='$idCont'>
                            $nomeCont
                        </option>
                        ";
                    }
                }
                ?>
            </select>
        </div>
    </div>     
    <div class="form-group col-lg-5" align="left">
        <div class="form-group">
        <label>Tipo de Conta</label>
            <select class="form-control chosen" name="assConta">
                <option <?php if ($contaAss=="U") echo "selected";?>>Selecione a conta</option>
                <option <?php if ($contaAss=="C") echo "selected";?>>Caixa</option>
                <option <?php if ($contaAss=="B") echo "selected";?>>Banco</option>
            </select>
        </div>                          
    </div>
</div>
<br>
<div class="row">
    <div class="form-group col-lg-8" align="left">                                       
        <div class="input-group">
            <div class="checkbox">
                <label>
                    <?php
                    if ($status==1){
                        echo"<input name='statusConta' type='checkbox' checked>Recebido";
                    }else{
                        echo"<input name='statusConta' type='checkbox'>Recebido";
                    }
                    ?>
                </label>
                <label>
                    <input name="nofique" type="checkbox" value="">Notifique-me
                </label>
            </div>
        </div>
    </div>
</div>