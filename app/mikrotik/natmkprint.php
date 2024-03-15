        <div class="breadcrumb clearfix">
          <ul>
            <li><a href="index.php?app=Dashboard">Dashboard</a></li>
            <li><a href="index.php?app=NatMKPRINT">Firewall Nat</a></li>
            <li class="active">IP Firewall Nat</li>
          </ul>
        </div>
        
        <?php 
        // Check if the user has permission to access this page
        if($permissao['fr3'] == 'S') { 
        
            // Display success messages based on GET parameters
            if ($_GET['reg'] == '1') { 
                echo 
                '<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        <i class="fa fa-times-circle"></i></button>
                    <strong>Atenção!</strong> Filtro Nat cadastrado com sucesso. </div>';
            }
            if ($_GET['reg'] == '3') { 
                echo 
                '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        <i class="fa fa-times-circle"></i></button>
                    <strong>Atenção!</strong> Filtro Nat excluído com sucesso. </div>';
            }
        
            // Page header for Firewall Nat / Redirecionamentos
            echo 
            '<div class="page-header">
              <h1>Firewall Nat / Redirecionamentos</h1>
            </div>';
        
            // Display a button for creating a new filter and the table for managing filters
            echo 
            '<div class="row" id="powerwidgets">
              <div class="col-md-12 bootstrap-grid"> 
                <a href="index.php?app=NatMK" class="btn btn-info">NOVO FILTRO</a><br><br>
                <div class="powerwidget" id="" data-widget-editbutton="false">
                  <header>
                    <h2>Gerenciar<small>Filtros de Nat</small></h2>
                  </header>
                  <div class="inner-spacer">
                    <table class="table table-striped table-hover" id="table-1">
                      <thead>
                        <tr>
                          <th>Key</th>
                          <th>Cliente</th>
                          <th>Porta</th>
                          <th>COMENTÁRIO</th>
                          <th>Autenticação</th>
                          <th>Ações</th>
                        </tr>
                      </thead>
                      <tbody>';
                      
            // Fetch data from the router and display it in the table
            $servidor = $mysqli->query("SELECT * FROM servidores");
            $mk = mysqli_fetch_array($servidor);

            $API = new routeros_api();
            $API->debug = false;
            if ($API->connect(''.$mk[ip].'', ''.$mk[login].'', ''.$mk[senha].''')) {
                $ARRAY = $API->comm("/ip/firewall/nat/print");

                for ($i = 0; $i < count($ARRAY); ++$i) {
                    $first = $ARRAY[$i];

                    $ipfl = $first['to-addresses'];
                    $consultas = $mysqli->query("SELECT * FROM firewall WHERE toaddresses = '$ipfl' AND group by cliente order by id DESC");
                    $campo = mysqli_fetch_array($consultas);

                    $cliente = $campo['cliente'];
                    $qtds = $mysqli->query("SELECT * FROM clientes WHERE id = '$cliente'");
                    $cliente = mysqli_fetch_array($qtds)

                    // Display data in the table rows
                    echo 
                    '<tr>
                      <td>' . $first['.id'] . '</td>
                      <td>' . $cliente['nome'] . '</td>
                      <td>' . $campo['dstport'] . '</td>
                      <td>' . $campo['comentario'] . '</td>
                      <td>' . $campo['action'] . '</td>
                      <td>
                        <a href="javascript:void(0);" onclick="javascript: if (confirm('Deseja realmente excluir esse registro ?')) { window.location.href='?app=NatMK&id=' . base64_encode($campo['id']) . '&srv=' . base64_encode($campo['servidor']) . '&rmv=' . base64_encode($first['.id']) . '&Ex=Del' } else { void('') };" class="btn btn-danger tooltiped" data-toggle="tooltip" data-placement="top" title="Excluir"><i class="entypo-trash"></i></a>
                      </td>
                    </tr>';
                }
            }
            $API->disconnect();
            
            echo 
                  '</tbody>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Cliente</th>
                      <th>Porta</th>
                      <th>COMENTÁRIO</th>
                      <th>Autenticação</th>
                      <th>Ações</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
        	
          </div>
        </div> 
      </div>
      
      
      <?php 
        } else { 
        // Display an error message if
