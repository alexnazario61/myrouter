<?php

namespace Cnab\Retorno;

interface IArquivo
{
        /**
         * Retorna todos os detalhes
         * @return iRetornoDetalhe[] An array of iRetornoDetalhe objects representing all the details
         */
        public function listDetalhes();
        
        /**
         * Retorna o numero da conta
         * @return String The account number as a string
         */
        public function getConta();
        
        /**
         * Retorna o digito de auto conferencia da conta
         * @return String The account's auto-conferencing digit as a string
         */
        public function getContaDac();
        
        /**
         * Retorna o codigo do banco
         * @return String The bank code as a string
         */
        public function getCodigoBanco();
        
        /**
         * Retorna a data de geração do arquivo
         * @return \DateTime The file generation date as a DateTime object
         */
        public function getDataGeracao();
        
        /**
         * Retorna o objeto DateTime da data crédito do arquivo
         * Poderá ser removido, pois em alguns bancos essa data só aparece no detalhe
         * @return \DateTime The file credit date as a DateTime object. This may be removed since some banks only include this date in the detail.
         */
        public function getDataCredito();
}
