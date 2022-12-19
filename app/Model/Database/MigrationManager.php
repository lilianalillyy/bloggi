<?php declare(strict_types = 1);

namespace App\Model\Database;

use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\MigratorConfiguration;
use Doctrine\Migrations\Version\Version;
use Symfony\Component\Console\Input\ArrayInput;
use Doctrine\Migrations\Query\Query;

class MigrationManager {

    public function __construct(
        private DependencyFactory $dependencyFactory
    ) {
    }

    /**
     * Create a migrator configuration
     */
    public function getMigratorConfiguration(?ArrayInput $input = null) {
        $migratorConfigurationFactory = $this->dependencyFactory->getConsoleInputMigratorConfigurationFactory();
        return $migratorConfigurationFactory->getMigratorConfiguration($input ?? new ArrayInput([]));
    }

    /**
     * Resolve a version alias
     * 
     * @param string $alias
     * @return Version
     */
    public function resolveVersionAlias(string $alias): Version {
        return $this->dependencyFactory->getVersionAliasResolver()->resolveVersionAlias($alias);
    }

    /**
     * Migrate to a specified version.
     * 
     * @param Version $version
     * @param MigratorConfiguration $migratorConfiguration
     * @return array<string, Query>
     */
    public function migrate(Version $version, MigratorConfiguration $migratorConfiguration): array {
        $plan = $this->dependencyFactory->getMigrationPlanCalculator()->getPlanUntilVersion($version);
        $migrator = $this->dependencyFactory->getMigrator();
        
        return $migrator->migrate($plan, $migratorConfiguration);
    }

}