<?php

namespace {

    require_once "../Spyc.php";

    use PHPUnit\Framework\TestCase;

    class ParseTest extends TestCase
    {
        /**
         * @var array
         */
        protected $yaml;

        protected function setUp(): void
        {
            $this->yaml = spyc_load_file('../spyc.yaml');
        }

        protected function tearDown(): void
        {
            unset($this->yaml);
        }

        // ... rest of the test methods ...
    }
}
