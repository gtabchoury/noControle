<?php

$userID = $_SESSION['usuario_id'];
$total = 0;

$query = "SELECT * FROM nc_contas WHERE conta_userID=$userID AND conta_tipo='R' ORDER BY conta_data DESC;";
$result = mysqli_query($mysqli, $query);
    $rowcount=mysqli_num_rows($result);

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $nome = $row['conta_nome'];
        $fonte = $row['conta_fonteID'];
        $valor = $row['conta_valor'];
        $total=$total+$valor;
        $valor =number_format($valor,2,',','');
        $data = $row['conta_data'];
        $status = $row['conta_status'];
        if ($fonte!=null){
            $query = "SELECT contato_nome from nc_contatos WHERE contato_id=? ";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('i', $fonte);
            $stmt->execute();
            $stmt->bind_result($fonte);

            if (!$stmt->fetch()){
                $fonte="";
            }

            $stmt->close();
        }
        if ($status==1){
            echo "
            <tr>
                <td style='vertical-align: middle;'><font size='3px'>$nome</font></td>
                <td style='vertical-align: middle;'><font size='3px'>$fonte</font></td>
                <td style='vertical-align: middle;'><font size='3px'>R$$valor</font></td>
                <td style='vertical-align: middle;'><font size='3px'>"; echo date('d/m/Y', strtotime($data)); echo"</font></td>
                <td style='vertical-align: middle;' class='center'><font size='3px'><i class='fa fa-check fa-fw'></i> Recebido</font></td>
                <td style='vertical-align: middle;' align='center'>
                    <a>
                    <font color='#d9534f'><i class='fa fa-remove btn btn-danger'></i></font>
                    </a>
                    <a>
                    <font color='#337ab7'><i class='fa fa-pencil btn btn-primary'></i></font>
                    </a>
                </td>
            </tr>
            ";
        }else{
            echo "
            <tr>
                <td style='vertical-align: middle;'><font size='3px'>$nome</font></td>
                <td style='vertical-align: middle;'><font size='3px'>$fonte</font></td>
                <td style='vertical-align: middle;'><font size='3px'>R$$valor</font></td>
                <td style='vertical-align: middle;'><font size='3px'>"; echo date('d/m/Y', strtotime($data)); echo"</font></td>
                <td style='vertical-align: middle;' class='center'><font size='3px'><i class='fa fa-times fa-fw'></i> Não recebido</font></td>
                <td style='vertical-align: middle;' align='center'>
                    <a>
                    <font color='#d9534f'><i class='fa fa-remove btn btn-danger'></i></font>
                    </a>
                    <a>
                    <font color='#337ab7'><i class='fa fa-pencil btn btn-primary'></i></font>
                    </a>
                </td>
            </tr>
            ";
        }
        
    }

    echo "  </tbody>
        </table>";

    $total =number_format($total,2,',','');
    echo "<h3 align='center'><b>Total a receber: </b>R$$total</h3><br>";
    echo "<div class='col-lg-12' align='center'><a class='btn btn-primary'>Gerar Arquivo PDF</a><br></div><br><br>";
?>