<?php

declare(strict_types = 1);

use JsonEvaluator\Evaluate;
use PHPUnit\Framework\TestCase;

final class EvaluateTest extends TestCase
{
    private $testCases = [
        // String
        [
            'instance'  => [
                'compare'   => [
                    'type'  => 'string',
                    'value' => 'hello',
                ],
                'compareTo' => [
                    'type'  => 'string',
                    'value' => 'hello',
                ],
                'operator'  => '==',
            ],
            'expected'  => true
        ],
        [
            'instance'  => [
                'compare'   => [
                    'type'  => 'string',
                    'value' => 'hello',
                ],
                'compareTo' => [
                    'type'  => 'string',
                    'value' => 'hi',
                ],
                'operator'  => '==',
            ],
            'expected'  => false
        ],
        [
            'instance'  => [
                'compare'   => [
                    'type'  => 'string',
                    'value' => 'hello',
                ],
                'compareTo' => [
                    'type'  => 'string',
                    'value' => 'hello',
                ],
                'operator'  => '!=',
            ],
            'expected'  => false
        ],
        [
            'instance'  => [
                'compare'   => [
                    'type'  => 'string',
                    'value' => 'hello',
                ],
                'compareTo' => [
                    'type'  => 'string',
                    'value' => 'hi',
                ],
                'operator'  => '!=',
            ],
            'expected'  => true
        ],
        // Number
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'number',
                    'value' => 0,
                ],
                'compareTo' => [
                    'type'  => 'number',
                    'value' => 0,
                ],
                'operator'  => '==',
            ],
            'expected'  => true
        ],
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'number',
                    'value' => 0,
                ],
                'compareTo' => [
                    'type'  => 'number',
                    'value' => 1,
                ],
                'operator'  => '==',
            ],
            'expected'  => false
        ],
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'number',
                    'value' => 0,
                ],
                'compareTo' => [
                    'type'  => 'number',
                    'value' => 1,
                ],
                'operator'  => '>',
            ],
            'expected'  => false
        ],
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'number',
                    'value' => 0,
                ],
                'compareTo' => [
                    'type'  => 'number',
                    'value' => 1,
                ],
                'operator'  => '<',
            ],
            'expected'  => true
        ],
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'number',
                    'value' => 0,
                ],
                'compareTo' => [
                    'type'  => 'number',
                    'value' => 1,
                ],
                'operator'  => '!=',
            ],
            'expected'  => true
        ],
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'number',
                    'value' => 0,
                ],
                'compareTo' => [
                    'type'  => 'number',
                    'value' => 0,
                ],
                'operator'  => '!=',
            ],
            'expected'  => false
        ]
        // TODO: test booleans
        // TODO: test expressions
        // TODO: test fields
    ];

    public function testBasics()
    {   
        $evaluator = new Evaluate();

        $testCases = json_decode(json_encode($this->testCases, 0));

        foreach ($testCases as $testCase) {
            $this->assertEquals(
                $testCase->expected,
                $evaluator->evaluate($testCase->instance, [])
            );
        }
    }
}
