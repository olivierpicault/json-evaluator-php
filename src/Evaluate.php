<?php

namespace JsonEvaluator;

use JsonEvaluator\Validate;
use stdClass;

class Evaluate
{
    public function evaluateSingle(stdClass $instance, array $fields) {
        $compare = $instance->compare->value;
        $compareTo = $instance->compareTo->value;
    
        if ($instance->compare->type === 'expression') {
            $compare = $this->evaluateSingle($compare, $fields);
        }
        if ($instance->compareTo->type === 'expression') {
            $compareTo = this.evaluateSingle($compareTo, $fields);
        }
    
        if ($instance->compare->type === 'field') {
            $compare = $fields[$compare];
        }
        if ($instance->compareTo->type === 'field') {
            $compareTo = $fields[$compareTo];
        }
    
        $operator = strtolower($instance->operator);
        switch ($operator) {
            case '==':
                return $compare === $compareTo;
            case '!=':
                return $compare !== $compareTo;
            case '>':
                return $compare > $compareTo;
            case '<':
                return $compare < $compareTo;
            case '>=':
                return $compare >= $compareTo;
            case '<=':
                return $compare <= $compareTo;
            case '&&':
            case 'and':
                return $compare && $compareTo;
            case '||':
            case 'or':
                return $compare || $compareTo;
            default:
            // Should never happen
                return null;
        }
    }

    public function evaluateMultiple(stdClass $instance, array $fields) {
        $result = null;
        $operator = $instance->operator->toLowerCase();
        
        foreach ($instance->conditions as $condition) {
            if (property_exists($condition, 'conditions') && ($operator === ('and' || '&&'))) {
                if ($result === null) {
                    $result = $this->evaluateMultiple($condition, $fields);
                } else {
                    $result = $result && $this->evaluateMultiple($condition, $fields);
                }
            } else if (property_exists($condition, 'conditions') && ($operator === ('or' || '||'))) {
                if ($result === null) {
                    $result = $this->evaluateMultiple($condition, $fields);
                } else {
                    $result = $result || $this->evaluateMultiple($condition, $fields);
                }
            }

            if (!property_exists($condition, 'conditions') && ($operator === ('and' || '&&'))) {
                if ($result === null) {
                    $result = $this->evaluateSingle($condition, $fields);
                } else {
                    $result = $result && $this->evaluateSingle($condition, $fields);
                }
            } else if (!property_exists($condition, 'conditions') && ($operator === ('or' || '||'))) {
                if ($result === null) {
                    $result = $this->evaluateSingle($condition, $fields);
                } else {
                    $result = $result || $this->evaluateSingle($condition, $fields);
                }
            }
        }

        return $result;
    }

    public function evaluate(stdClass $instance, array $fields) {
        $validator = new Validate;
        $type = $validator->checkOperationtype($instance);
  
      if ($type === 'single') {
        return $this->evaluateSingle($instance, $fields);
      } else if ($type === 'multiple') {
        return $this->evaluateMultiple($instance, $fields);
      }
      return null;
    }
}
