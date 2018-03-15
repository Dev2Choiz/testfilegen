<?php

namespace Dev\FileGenTestBundle\Service;

use FileGen\FileGen;

class Compare
{
    /** @var  FileGen $reader */
    protected $filegen;
    /** @var  string $fileName */
    protected $fileName;
    /** @var  int $nbCol */
    protected $nbCol;
    /** @var  int $nbLine */
    protected $nbLine;
    /** @var \Faker\Generator $faker */
    protected $faker;

    public function __construct()
    {
        $this->fileName = __DIR__ . '/file1.csv';
        $this->filegen = FileGen::factory($this->fileName);
        $this->faker = \Faker\Factory::create();
        $this->nbCol = 10;
    }

    /**
     * @return bool
     */
    public function write()
    {
        $this->filegen = FileGen::factory($this->fileName);
        $this->filegen->ftruncate(0);

        // Ecriture d'un csv avec $this->nbLine lignes
        $header = 'colonne' . implode(', colonne', range(1, $this->nbCol)) . PHP_EOL;
        $this->writeFile($header);
        for ($i = 0; $i < $this->nbLine; ++$i) {
            $this->writeFile($this->getLine());
        }

        return true;
    }

    /**
     * @return array
     */
    public function read()
    {
        $result = [];

        // Lecture avec un generateur avec FileGen
        $memoryStart = memory_get_usage();
        $lines = $this->filegen->readLinePerLine();
        foreach ($lines as $key => $value) {
        }
        $result['filegen'] = memory_get_usage() - $memoryStart;

        // Lecture de tout le fichier sans generateur
        $memoryStart = memory_get_usage();
        $lines = file($this->fileName);
        foreach ($lines as $key => $value) {
        }
        $result['normal'] = memory_get_usage() - $memoryStart;
        $this->filegen = null;

        return $result;
    }

    public function getLine()
    {
        $data = [];
        for ($j = 0; $j < $this->nbCol; ++$j) {
            $data[] = substr($this->faker->name(), 0, 10);
        }
        return implode(';', $data) . PHP_EOL;
    }

    public function writeFile($line)
    {
        $this->filegen->writeFile($line);
    }

    /**
     * @return Reader
     */
    public function getReader (): Reader
    {
        return $this->reader;
    }

    /**
     * @param Reader $reader
     * @return Compare
     */
    public function setReader (Reader $reader): Compare
    {
        $this->reader = $reader;
        return $this;
    }

    /**
     * @return Writer
     */
    public function getWriter (): Writer
    {
        return $this->writer;
    }

    /**
     * @param Writer $writer
     * @return Compare
     */
    public function setWriter (Writer $writer): Compare
    {
        $this->writer = $writer;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbLine (): int
    {
        return $this->nbLine;
    }

    /**
     * @param int $nbLine
     * @return Compare
     */
    public function setNbLine (int $nbLine): Compare
    {
        $this->nbLine = $nbLine;
        return $this;
    }
}
