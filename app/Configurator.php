<?php declare(strict_types = 1);

namespace App;

use Contributte\Bootstrap\ExtraConfigurator;

class Configurator extends ExtraConfigurator {
    
    private string $appDir;

    private string $rootDir;
    
    private string $setupDir;

    private string $publicDir;

    public function __construct(
        string $appDir = __DIR__,
        ?string $rootDir = null,
        ?string $setupDir = null,
        ?string $publicDir = null
    ) {
        parent::__construct();
        
        $this->appDir = $appDir;
        $this->rootDir = $rootDir ?: realpath($this->appDir . "/..");
        $this->setupDir = $setupDir ?: realpath($this->rootDir . "/setup");
        $this->publicDir = $publicDir ?: realpath($this->rootDir . "/www");

        $this->addParameters([
            "appDir" => $this->appDir,
            "setupDir" => $this->setupDir,
            "rootDir" => $this->rootDir,
            "publicDir" => $this->publicDir
        ]);
    }

    public function getAppDir(): string
    {
        return $this->appDir;
    }

    public function setAppDir(string $appDir): static
    {
        $this->appDir = $appDir;

        return $this;
    }

    public function getRootDir(): string
    {
        return $this->rootDir;
    }

    public function setRootDir(string $rootDir): static
    {
        $this->rootDir = $rootDir;

        return $this;
    }

    public function getSetupDir(): string
    {
        return $this->setupDir;
    }

    public function setSetupDir(string $setupDir): static
    {
        $this->setupDir = $setupDir;

        return $this;
    }

    public function getPublicDir(): string
    {
        return $this->publicDir;
    }

    public function setPublicDir(string $publicDir): static
    {
        $this->publicDir = $publicDir;

        return $this;
    }

    public function loadConfigs(array $configs): void
    {
        foreach ($configs as $config) {
            $this->addConfig($this->rootDir . "/config/$config.neon");
        }
    }

    public function addConfig($config)
    {
        parent::addConfig($config);
    }

}