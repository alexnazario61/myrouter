        <div class="breadcrumb clearfix">
          <ul>
            <li><a href="index.php?app=Dashboard">Dashboard</a></li>
            <li class="active">Financeiro</li>
          </ul>
        </div>
        
        <?php 
        // Check if a registration was successfully altered, deleted, or an email was sent
        if ($_GET['reg'] == '2') {
            // Display a success message for a successfully altered registration
            echo "
            <div class='alert alert-info alert-dismissable'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
            <i class='fa fa-times-circle'></i></button>
            <strong>Atenção!</strong> Fatura alterada com sucesso. </div>
            ";
        } elseif ($_GET['reg'] == '3') {
            // Display a success message for a successfully deleted registration
            echo "
            <div class='alert alert-danger alert-dismissable'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
            <i class='fa fa-times-circle'></i></button>
            <strong>Atenção!</strong> Fatura excluída com sucesso. </div>
            ";
        } elseif ($_GET['reg'] == '5') {
            // Display a success message for a successfully sent email
            echo "
            <div class='alert alert-info alert-dismissable'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
            <i class='fa fa-times-circle'></i></button>
            <strong>Atenção!</strong> Fatura Enviada com Sucesso. </div>
            ";
        } elseif ($_GET['reg'] == '6') {
            // Display an error message for an unsuccessful email configuration
            echo "
            <div class='alert alert-danger alert-dismissable'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
            <i class='fa fa-times-circle'></i></button>
            <strong>Atenção!</strong> Ocorreu algum erro na configuração do seu email, Mensagem não foi enviada. </div>
            ";
        }
        ?>

        <?php 
        // Check if the user has permission to view this page
        if ($permissao['f1'] == 'S') {
        
        ?>

        <div class="page-header">
          <h1>Faturas <small>Ano de <?php echo date('Y'); ?></small></h1>  
        </div>

        <div class="row" id="powerwidgets">
          <div class="col-md-12 bootstrap-grid"> 
      	  
            <div class="powerwidget green" id="" data-widget-editbutton="false">
              <header>
                <h2>Gerenciar<small>Faturas</small></h2>
              </header>
              <div class="inner-spacer">

              <!-- Export options dropdown -->
              <div class="btn-group">
                <button class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bars"></i> EXPORTAR </button>
                <ul class="dropdown-menu " role="menu">
                  <li><a href="#" onClick ="$('#table-1').tableExport({type:'json',escape:'false'});"> <img src='assets/images/json.png' width='24px'> JSON</a></li>
                  <li class="divider"></li>
                  <li><a href="#" onClick ="$('#table-1').tableExport({type:'xml',escape:'false',ignoreColumn:'[6]'});"> <img src='assets/images/xml.png' width='24px'> XML</a></li>
                  <li><a href="#" onClick ="$('#table-1').tableExport({type:'sql'});"> <img src='assets/images/sql.png' width='24px'> SQL</a></li>
                  <li class="divider"></li>
                  <li><a href="#" onClick ="$('#table-1').tableExport({type:'csv',escape:'false'});"> <img src='assets/images/csv.png' width='24px'> CSV</a></li>
                  <li><a href="#" onClick ="$('#table-1').tableExport({type:'txt',escape:'false'});"> <img src='assets/images/txt.png' width='24px'> TXT</a></li>
                  <li class="divider"></li>				
                  <li><a href="#" onClick ="$('#table-1').tableExport({type:'excel',escape:'false'});"> <img src='assets/images/xls.png' width='24px'> XLS</a></li>
                  <li><a href="#" onClick ="$('#table-1').tableExport({type:'doc',escape:'false'});"> <img src='assets/images/word.png' width='24px'> Word</a></li>
                  <li><a href="#" onClick ="$('#table-1').tableExport({type:'powerpoint',escape:'false'});"> <img src='assets/images/ppt.png' width='24px'> PowerPoint</a></li>
                  <li class="divider"></li>
                  <li><a href="#" onClick ="$('#table-1').tableExport({type:'png',escape:'false'});"> <img src='assets/images/png.png' width='24px'> PNG</a></li>
                  <li><a href="#" onClick ="$('#table-1').tableExport({type:'pdf',pdfFontSize:'9',escape:'false',ignoreColumn:'[6]'});"> <img src='assets/images/pdf.png' width='24px'> PDF</a></li>
                </ul>
              
