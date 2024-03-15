<?php
session_start();
require_once('conexao.php');

// ... (the rest of the original code)

<div class="breadcrumb clearfix">
  <ul>
    <li><a href="?app=Dashboard">Dashboard</a></li>
    <li><a href="?app=ControleBanda">Mikrotik</a></li>
    <li class="active">Controle de Banda</li>
  </ul>
</div>

<div class="page-header">
  <h1>Cadastro<small> Nova Regra</small></h1>
</div>

<div class="powerwidget red" id="most-form-elements" data-widget-editbutton="false">
  <header>
    <h2>Cadastro<small>Controle de Banda</small></h2>
  </header>
  <div class="inner-spacer">
    <form action="" method="POST" class="orb-form">
      <fieldset>

        <!-- ... (the rest of the original form fields) -->

        <section class="col col-3">
          <label class="label">Download (300 = 300kbps)</label>
          <label class="input">
            <input type="text" name="download" oninput="kbps(this);" value="<?php echo htmlspecialchars(@$campo['download'], ENT_QUOTES); ?>" required>
          </label>
        </section>

        <!-- ... (the rest of the original form fields) -->

      </fieldset>
      <footer>
        <?php if (isset($campo['id']) && $campo['id'] <> '') { ?>
          <input type="submit" name="editar" class="btn btn-primary" value="Atualizar">
          <input type="hidden" name="bandaid" value="<?php echo htmlspecialchars(@$campo['id'], ENT_QUOTES); ?>">
        <?php } else { ?>
          <input type="submit" name="cadastrar" class="btn btn-success" value="Cadastrar">
        <?php } ?>
      </footer>
    </form>
  </div>
</div>
