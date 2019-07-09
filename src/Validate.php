<?php

namespace JsonEvaluator;

class Validate
{
    private $allowedTypes = ['string', 'number', 'boolean', 'expression', 'field'];
    private $allowedMultipleOperators = ['and', 'or', '||', '&&'];

    public function checkOperationType($node)
    {
        $type = null;
        if (property_exists($node, 'operator') and property_exists($node, 'conditions')) {
            $type = 'multiple';
        } else if (property_exists($node, 'operator') and !property_exists($node, 'conditions')) {
            $type = 'single';
        }
        return $type;
    }

    public function validateProperties($node) {
        $errors = [];
        $valid = true;

        // Check 'compare' node is present and is an object
        if (!property_exists($node, 'compare')) {
            $errors[] = '"compare" property is missing';
            $valid = false;
        } else if (!is_object($node->compare)) {
            $errors[] = '"compare" must be an object';
            $valid = false;
        }

        // Check 'compareTo' node is present and is an object
        if (!property_exists($node, 'compareTo')) {
            $errors[] = '"compareTo" property is missing';
            $valid = false;
        } else if (!is_object($node->compareTo)) {
            $errors[] = '"compareTo" must be an object';
            $valid = false;
        }

        if (!property_exists($node, 'operator')) {
            $errors[] = '"operator" property is missing';
            $valid = false;
        }

        return (object) [
            'valid'     => $valid,
            'errors'    => $errors,
        ];
    }

    public function validateMultipleProperties($node) {
        $errors = [];
        $valid = true;
    
        if (!property_exists($node, 'conditions')) {
          $valid = false;
          $errors[] = '"conditions" property is missing';
        } else if (!is_array($node->conditions)) {
          $valid = false;
          $errors[] = '"conditions" must be an array';
        }
    
        if (!property_exists($node, 'operator')) {
          $valid = false;
          $errors[] = '"operator" property is missing';
        } else if (!allowedMultipleOperators.includes(node.operator.toLowerCase())) {
          $valid = false;
          $errors[] = `"operator" must be one of ${allowedMultipleOperators.join(', ')}`;
        }
    
        return (object) [
            'valid'     => $valid,
            'errors'    => $errors
        ];
    }

    /*
    **  Check "compare" and "compareTo" objects have all the needed properties
    */
    public function validatePropertiesProperties($node) {
        $errors = [];
        $valid = true;

        foreach (['compare', 'compareTo'] as $prop) {
            foreach (['type', 'value'] as $propProp) {
                if (!property_exists($node->{$prop}, $propProp)) {
                    $valid = false;
                    $errors[] = '"' . $propProp . '" property is missing from "' . $node->{$prop} . '"';
                }
            }
        }

        return (object) [
            'valid'     => $valid,
            'errors'    => $errors,
        ];
    }

    /*
    **  Check types given are allowed
    */
    public function validateTypes($node) {
        $errors = [];
        $valid = true;

        if (!(in_array($node->compare->type, $this->allowedTypes) && in_array($node->compareTo->type, $node))) {
            $valid = fase;
            $errors[] = '"type" must be on of ' . implode(', ', $this->allowedTypes);
        }

        return (object) [
            'valid'     => $valid,
            'errors'    => $errors,
        ];
    }

     /*
    **  Check we are comparing two comparable types
    */
    public function validateComparison(object $node) {
        $errors = [];
        $valid = true;

        // Wildcard for 'field'
        // 'field' can be any type and we don't know it in advance
        if ($node->compare->type === 'field' || $node->compareTo->type === 'field') {
            return (object) [
                'valid'     => true,
                'errors'    => [],
            ];
        }

        // 'Expression' can only be compare to a boolean or another 'expression'
        if ($node->compare->type === 'expression' || $node->compareTo->type === 'expression') {
            if ($node->compare->type === 'expression' && !['expression', 'boolean'].includes($node->compareTo->type)) {
                $errors[] = '"expression" type can only be compared to "boolean" or "expression" types';
                $valid = false;
            }
            if ($node->compareTo->type === 'expression' && !['expression', 'boolean'].includes($node->compare->type)) {
                $errors[] = '"expression" type can only be compared to "boolean" or "expression" types';
                $valid = false;
            }
        }
        // Besides 'expression' case all other types should be compare to the same type
        else if ($node->compare->type !== $node->compareTo->type) {
            $errors[] = 'You are not comparing the same types for "compare" and "compareTo"';
            $valid = false;
        }

        return (object) [
            'valid'     => $valid,
            'errors'    => $errors,
        ];
    }

    /*
    **  Check value is the right type
    */
    public function validateValue(object $node, object $fields) {
        $errors = [];
        $valid = true;

        $compareType = $node->compare->type;
        $compareToType = $node->compareTo->type;

        $specialTypes = ['expression', 'field'];

        // Basic cases
        if (!in_array($compareType, $specialTypes) && in_array($compareType, $this->allowedTypes) && (gettype($node->compare->value) !== $compareType)) {
            $valid = false;
            $errors[] = '"' . $$node->compare->value . '" is not "' . $compareType . '"';
        }
        if (!in_array($compareToType, $specialTypes) && in_array($compareToType, $this->allowedTypes) && (gettype($node->compareTo->value) !== $compareToType)) {
            $valid = false;
            $errors[] = '"' . $$node->compareTo->value . '" is not "' . $compareToType . '"';
        }
        // Special case: expression
        if ($compareType === 'expression' && (gettype($node->compare.value)) !== 'object') {
            $valid = false;
            $errors[] = '"' . $node->compare->value . '" is not "' . $compareType . '"';
        }
        if ($compareToType === 'expression' && (gettype($node->compareTo->value)) !== 'object') {
            $valid = false;
            $errors[] = '"' . $node->compareTo->value . '" is not "' . $compareToType . '"';
        }

        // Special case: field
        if ($compareType === 'field' && (property_exists($fields, $node->compare->value) === false)) {
            $valid = false;
            $errors[] = '"' . $$node->compare.value . '" is not a valid field value';
        }
        if ($compareToType === 'field' && (property_exists($fields, $node->compareTo->value) === false)) {
            $valid = false;
            $errors[] = '"' . $$node->compareTo.value . '" is not a valid field value';
        }

        return (object) [
            'valid'     => $valid,
            'errors'    => $errors,
        ];
    }
}
