<?php

function limpaVariavel($valor)
{
    $valor = trim($valor);
    $valor = str_replace([".", ",", "-", "/", "(", ")"], "", $valor);
    return $valor;
}

function geraNumeroPedido()
{
    global $mysqli;
    $qr_numero = $mysqli->query("SELECT * FROM assinaturas ORDER BY id DESC");
    $row_numero = mysqli_fetch_array($qr_numero);
    $numero = str_pad($row_numero['id'] + 1, 9, "0", STR_PAD_LEFT);
    return $numero;
}

function gravaLog($acao, $detalhes)
{
    global $idpuser, $ipremoto, $hora;
    $sql = "INSERT INTO log (admin, ip, data, acao, detalhes, query) VALUES (?, ?, ?, ?, ?, NULL)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sisis", $idpuser, $ipremoto, $hora, $acao, $detalhes);
    $stmt->execute();
}

function insereAssinatura($dados)
{
    global $mysqli;
    $campos = implode(",", array_keys($dados));
    $valores = implode(",", array_values($dados));
    $sql = "INSERT INTO assinaturas ($campos) VALUES ($valores)";
    $mysqli->query($sql);
}

function insereInstalacaoEquipamento($assinaturaId, $equipamentoId, $qtd, $obs)
{
    global $mysqli;
    $sql = "INSERT INTO instalacao_equipamentos (assinatura, equipamento, qtd, obs) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iisi", $assinaturaId, $equipamentoId, $qtd, $obs);
    $stmt->execute();
}

function atualizaAssinatura($dados, $where)
{
    global $mysqli;
    $campos = implode("=?,", array_keys($dados)) . "=?";
    $sql = "UPDATE assinaturas SET $campos WHERE $where";
    $stmt = $mysqli->prepare($sql);
    $params = array_values($dados);
    $params[] = $where;
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);
    $stmt->execute();
}

function excluiInstalacaoEquipamento($id)
{
    global $mysqli;
    $sql = "DELETE FROM instalacao_equipamentos WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

function excluiAssinatura($id)
{
    global $mysqli;
    $sql = "DELETE FROM assinaturas WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

function excluiFinanceiro($pedido)
{
    global $mysqli;
    $sql = "DELETE FROM financeiro WHERE pedido = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $pedido);
    $stmt->execute();
}

function excluiControleBanda($pedido)
{
    global $mysqli;
    $sql = "DELETE FROM controlebanda WHERE pedido = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $pedido);
    $stmt->execute();
}

function excluiRadcheck($pedido)
{
    global $mysqli;
    $sql = "DELETE FROM radcheck WHERE pedido = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $pedido);
    $stmt->execute();
}

function excluiRadusergroup($pedido)
{
    global $mysqli;
    $sql = "DELETE FROM radusergroup WHERE pedido = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $pedido);
    $stmt->execute();
}

function excluiRadreply($pedido)
{
    global $mysqli;
    $sql = "DELETE FROM radreply WHERE pedido = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $pedido);
    $stmt->execute();
}

function insereFinanceiro($dados)
{
    global $mysqli;
    $campos = implode(",", array_keys($dados));
    $valores = implode(",", array_values($dados));
    $sql = "INSERT INTO financeiro ($campos) VALUES ($valores)";
    $mysqli->query($sql);
}

function atualizaFinanceiro($dados, $where)
{
    global $mysqli;
    $campos = implode("=?,", array_keys($dados)) . "=?";
    $sql = "UPDATE financeiro SET $campos WHERE $where";
    $stmt = $mysqli->prepare($sql);
    $params = array_values($dados);
    $params[] = $where;
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);
    $stmt->execute();
}

function insereControleBanda($dados)
{
    global
