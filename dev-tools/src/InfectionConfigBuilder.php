<?php

/*
 * This file is part of PHP CS Fixer: custom fixers.
 *
 * (c) 2018-2020 Kuba Werłos
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpCsFixerCustomFixersDev;

use Infection\Mutator\ProfileList;

final class InfectionConfigBuilder
{
    private const UNWANTED_MUTATORS = [
        'Decrement',
        'DecrementInteger',
        'FalseValue',
        'GreaterThan',
        'GreaterThanOrEqualTo',
        'IdenticalEqual',
        'Increment',
        'IncrementInteger',
        'IntegerNegation',
        'LessThan',
        'LessThanOrEqualTo',
        'LogicalAnd',
        'LogicalNot',
        'LogicalOr',
        'Minus',
        'NotIdentical',
        'NotIdenticalNotEqual',
        'OneZeroInteger',
        'Plus',
        'TrueValue',
    ];

    /**
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $config = [
            '$schema' => './vendor/infection/infection/resources/schema.json',
            'source' => ['directories' => ['../src']],
            'timeout' => 10,
            'logs' => [
                'text' => 'php://stdout',
                'github' => true,
                'badge' => ['branch' => 'master'],
            ],
            'phpUnit' => [
                'configDir' => '..',
                'customPath' => '../vendor/phpunit/phpunit/phpunit',
            ],
            'mutators' => [],
            'bootstrap' => '../vendor/autoload.php',
        ];

        $mutators = \array_keys(ProfileList::ALL_MUTATORS);
        \sort($mutators);

        foreach ($mutators as $mutator) {
            if (\in_array($mutator, self::UNWANTED_MUTATORS, true)) {
                continue;
            }

            $config['mutators'][$mutator] = true;
        }

        $config['mutators']['ArrayItemRemoval'] = [
            'settings' => ['remove' => 'all'],
            'ignore' => [
                'PhpCsFixerCustomFixers\\Fixer\\*::getConfigurationDefinition',
                'PhpCsFixerCustomFixers\\Fixer\\*::getDefinition',
                'PhpCsFixerCustomFixers\\Fixer\\*::isCandidate',
            ],
        ];

        $config['mutators']['PublicVisibility'] = [
            'ignore' => [
                'PhpCsFixerCustomFixers\\Fixer\\AbstractFixer::name',
            ],
        ];

        return $config;
    }
}
