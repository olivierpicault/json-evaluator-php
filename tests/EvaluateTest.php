<?php

declare(strict_types = 1);

use JsonEvaluator\Evaluate;
use PHPUnit\Framework\TestCase;

final class EvaluateTest extends TestCase
{
    private $stringCases = [
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
    ];

    private $numberCases = [
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
                    'value' => 4,
                ],
                'compareTo' => [
                    'type'  => 'number',
                    'value' => 1,
                ],
                'operator'  => '>',
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
                'operator'  => '<',
            ],
            'expected'  => true
        ],
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'number',
                    'value' => 2,
                ],
                'compareTo' => [
                    'type'  => 'number',
                    'value' => 1,
                ],
                'operator'  => '<',
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
    ];

    private $booleanCases = [
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'boolean',
                    'value' => true,
                ],
                'compareTo' => [
                    'type'  => 'boolean',
                    'value' => true,
                ],
                'operator'  => '==',
            ],
            'expected'  => true
        ],
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'boolean',
                    'value' => true,
                ],
                'compareTo' => [
                    'type'  => 'boolean',
                    'value' => false,
                ],
                'operator'  => '==',
            ],
            'expected'  => false
        ],
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'boolean',
                    'value' => true,
                ],
                'compareTo' => [
                    'type'  => 'boolean',
                    'value' => true,
                ],
                'operator'  => '!=',
            ],
            'expected'  => false
        ],
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'boolean',
                    'value' => true,
                ],
                'compareTo' => [
                    'type'  => 'boolean',
                    'value' => false,
                ],
                'operator'  => '!=',
            ],
            'expected'  => true
        ],
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'boolean',
                    'value' => true,
                ],
                'compareTo' => [
                    'type'  => 'boolean',
                    'value' => true,
                ],
                'operator'  => '&&',
            ],
            'expected'  => true
        ],
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'boolean',
                    'value' => true,
                ],
                'compareTo' => [
                    'type'  => 'boolean',
                    'value' => true,
                ],
                'operator'  => 'and',
            ],
            'expected'  => true
        ],
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'boolean',
                    'value' => true,
                ],
                'compareTo' => [
                    'type'  => 'boolean',
                    'value' => false,
                ],
                'operator'  => 'and',
            ],
            'expected'  => false
        ],
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'boolean',
                    'value' => true,
                ],
                'compareTo' => [
                    'type'  => 'boolean',
                    'value' => false,
                ],
                'operator'  => 'or',
            ],
            'expected'  => true
        ],
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'boolean',
                    'value' => false,
                ],
                'compareTo' => [
                    'type'  => 'boolean',
                    'value' => true,
                ],
                'operator'  => '||',
            ],
            'expected'  => true
        ]
    ];

    private $expressionCases = [
        [
            'instance' => [
                'compare'   => [
                    'type'  => 'expression',
                    'value' => [
                        'compare'   => [
                            'type'  => 'string',
                            'value' => 'olivier'
                        ],
                        'compareTo' => [
                            'type'  => 'string',
                            'value' => 'stéphane',
                        ],
                        'operator'  =>  '==',
                    ]
                ],
                'compareTo' => [
                    'type'  => 'boolean',
                    'value' => true,
                ],
                'operator'  => '==',
            ],
            'expected'  => false
        ]
    ];

    private $fieldCases = [
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
                'compare'   => [
                    'type'  => 'field',
                    'value' => 'age',
                ],
                'compareTo' => [
                    'type'  => 'number',
                    'value' => 18,
                ],
                'operator'  => '>=',
            ],
            'expected'  => true
        ]
    ];

    public function testString()
    {   
        $evaluator = new Evaluate();

        $testCases = json_decode(json_encode($this->stringCases, 0));

        foreach ($testCases as $testCase) {
            $this->assertEquals(
                $testCase->expected,
                $evaluator->evaluate($testCase->instance, [])
            );
        }
    }

    public function testNumber()
    {   
        $evaluator = new Evaluate();

        $testCases = json_decode(json_encode($this->numberCases, 0));

        foreach ($testCases as $testCase) {
            $this->assertEquals(
                $testCase->expected,
                $evaluator->evaluate($testCase->instance, [])
            );
        }
    }

    public function testBooleans()
    {
        $evaluator = new Evaluate();

        $testCases = json_decode(json_encode($this->booleanCases, 0));

        foreach ($testCases as $testCase) {
            $this->assertEquals(
                $testCase->expected,
                $evaluator->evaluate($testCase->instance, [])
            );
        }
    }

    public function testExpression()
    {
        $evaluator = new Evaluate();

        $testCases = json_decode(json_encode($this->expressionCases, 0));

        foreach ($testCases as $testCase) {
            $this->assertEquals(
                $testCase->expected,
                $evaluator->evaluate($testCase->instance, [])
            );
        }
    }

    public function testFields()
    {
        $evaluator = new Evaluate();

        $testCases = json_decode(json_encode($this->fieldCases, 0));

        foreach ($testCases as $testCase) {
            $this->assertEquals(
                $testCase->expected,
                $evaluator->evaluate($testCase->instance, ['name' => 'olivier', 'age' => 31])
            );
        }
    }
}
