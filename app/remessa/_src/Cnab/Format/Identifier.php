<?php

namespace Cnab\Format;

class Identifier
{
    public function identifyFile(string $filename): array
    {
        if (!file_exists($filename)) {
            throw new \Exception('File does not exist: ' . $filename);
        }

        $file = \fopen($filename, 'r');
        $contents = \fread($file, \filesize($filename));
        \fclose($file);

        $lines = \explode("\n", $contents);

        if (\count($lines) < 2) {
            return null;
        }

        $length = $this->getMaxLineLength($lines);

        $bytes = $this->getBytes($length);

        $layout_versao = null;

        if ($bytes == 400) {
            $result = $this->parseFile400($lines);
        } elseif ($bytes == 240) {
            $result = $this->parseFile240($lines);
        } else {
            return null;
        }

        $result['bytes'] = $bytes;
        $result['layout_versao'] = $layout_versao;

        return $result;
    }

    private function getMaxLineLength(array $lines): int
    {
        $length = 0;
        foreach ($lines as $line) {
            $length = \max($length, \strlen($line));
        }

        return $length;
    }

    private function getBytes(int $length): int
    {
        if ($length == 240 || $length == 241) {
            return 240;
        } elseif ($length == 400 || $length == 401) {
            return 400;
        }

        return 0;
    }

    private function parseFile400(array $lines): array
    {
        $codigo_banco = \substr($lines[0], 76, 3);
        $codigo_tipo = \substr($lines[0], 1, 1);

        $tipo = null;

        if ($codigo_tipo == '1') {
            $tipo = 'remessa';
        } elseif ($codigo_tipo == '2') {
            $tipo = 'retorno';
        }

        return [
            'banco' => $codigo_banco,
            'tipo' => $tipo,
        ];
    }

    private function parseFile240(array $lines): array
    {
        $codigo_banco = \substr($lines[0], 0, 3);
        $codigo_tipo = \substr($lines[0], 142, 1);

        $layout_versao = null;

        if (\Cnab\Banco::CEF == $codigo_banco) {
            $layout_versao = \substr($lines[0], 163, 3);

            if ($layout_versao == '040' || $layout_versao == '050') {
                $layout_versao = 'sigcb';
            } else {
                $layout_versao =
