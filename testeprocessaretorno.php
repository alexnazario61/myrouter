<?php

//******************************************************************************
// Setup the testing environment by simulating a received RET file
//******************************************************************************
$_FILES['arquivo'] = array(
    'type'   => 'ret',          // File type (in this case, a RET file)
    'name'   => 'CN01075A.RET',  // Name of the RET file
    'tmp_name'=> __DIR__.'/CN01075A.RET'  // Temporary location of the RET file
);

//******************************************************************************
// Include the script that processes the RET file
//******************************************************************************
include 'processa.retorno.php';

