<?php

	// Include the Boleto class file
	include_once('config/Boleto.class.php');

	// Decode the cliente and assinatura GET parameters
	$cliente = base64_decode($_GET['cliente']);
	$assinatura = base64_decode($_GET['fatura']);
	$tipo = $_GET['tipo']; // 1 for boleto, 2 for duplicata

	// Create a new Boleto object
	$boleto = new Boleto;

	// Retrieve the empresa data from the database
	$empresas = mysql_query("SELECT * FROM empresa WHERE id = '1'");
	$empresa = mysql_fetch_array($empresas);

	/*
	// MIGRATION TO ANOTHER BANK COMMENTED OUT
	$financeiro2 = mysql_query("SELECT * FROM financeiro WHERE id = $assinatura");
	$financeiro_migracao = mysql_fetch_array($financeiro2);

	if ($financeiro_migracao['migracaodebanco'] == "CAIXA") {
		if ($tipo == 1) {
			$boleto->emitir_cef($cliente, $assinatura, $tipo);
		}
		if ($tipo == 2) {
			$boleto->emitir_cef($cliente, $assinatura, $tipo);
		}
	}
	*/

	// Emit the boleto based on the selected bank
	if ($empresa['banco'] == 1) { // BANCO DO BRASIL
		if ($tipo == 1) {
			$boleto->emitir_bb($cliente, $assinatura, $tipo);
		}
		if ($tipo == 2) {
			$boleto->emitir_bb($cliente, $assinatura, $tipo);
		}
	}

	if ($empresa['banco'] == 2) { // BRADESCO
		if ($tipo == 1) {
			$boleto->emitir_bradesco($cliente, $assinatura, $tipo);
		}
		if ($tipo == 2) {
			$boleto->emitir_bradesco($cliente, $assinatura, $tipo);
		}
	}

	if ($empresa['banco'] == 3) { // CEF
		if ($tipo == 1) {
			$boleto->emitir_cef($cliente, $assinatura, $tipo);
		}
		if ($tipo == 2) {
			$boleto->emitir_cef($cliente, $assinatura, $tipo);
		}
	}

	if ($empresa['banco'] == 4) { // ITAÚ
		if ($tipo == 1) {
			$boleto->emitir_itau($cliente, $assinatura, $tipo);
		}
		if ($tipo == 2) {
			$boleto->emitir_itau($cliente, $assinatura, $tipo);
		}
	}

	if ($empresa['banco'] == 5) { // SANTANDER
		if ($tipo == 1) {
			$boleto->emitir_santander($cliente, $assinatura, $tipo);
		}
		if ($tipo == 2) {
			$boleto->emitir_santander($cliente, $assinatura, $tipo);
		}
	}

	if ($empresa['banco'] == 6) { // SICOOB
		if ($tipo == 1) {
			$boleto->emitir_sicoob($cliente, $assinatura, $tipo);
		}
		if ($tipo == 2) {
			$boleto->emitir_sicoob($cliente, $assinatura, $tipo);
		}
	}

	if ($empresa['banco'] == 7) { // SICREDI
		if ($tipo == 1) {
			$boleto->emitir_sicredi($cliente, $assinatura, $tipo);
		}
		if ($tipo == 2) {
			$boleto->emitir_sicredi($cliente, $assinatura, $tipo);
		}
	}

	if ($empresa['banco
