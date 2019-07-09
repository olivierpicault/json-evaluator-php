<?php

declare(strict_types = 1);

use JsonEvaluator\Validate;
use PHPUnit\Framework\TestCase;

final class ValidateTest extends TestCase
{
    public function testSingleModeProperties()
    {
        $testCases = [
            [
                'instance' => [
                    'compare'   => [
                        'type'  => 'field',
                        'value' => 'name',
                    ],
                    'compareTo' => [
                        'type'  => 'string',
                        'value' => 'olivier',
                    ],
                    'operator'  => '==',
                ],
                'expected'  => true
            ],
            [
                'instance' => [
                    'compareTo' => [
                        'ype'  => 'string',
                        'value' => 'olivier',
                    ],
                    'operator'  => '==',
                ],
                'expected'  => false
            ],
            [
                'instance' => [
                    'compare'   => [
                        'type'  => 'field',
                        'value' => 'name',
                    ],
                    'operator'  => '==',
                ],
                'expected'  => false
            ],
            [
                'instance' => [
                    'compare'   => [
                        'type'  => 'field',
                        'value' => 'name',
                    ],
                    'compareTo' => [
                        'type'  => 'string',
                        'value' => 'olivier',
                    ],
                ],
                'expected'  => false
            ],
        ];

        $validator = new Validate();

        $testCases = json_decode(json_encode($testCases));

        foreach ($testCases as $testCase) {
            $this->assertEquals(
                $testCase->expected,
                $validator->validateProperties($testCase->instance)->valid
            );
        }
    }
}
