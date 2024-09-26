<?php

class __Mustache_c9fe1eed44916922b22d27371de4915c extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="mb-1 me-1 flex-grow-1">
';
        $buffer .= $indent . '    ';
        if ($parent = $this->mustache->loadPartial('core/search_input_auto')) {
            $context->pushBlockContext(array(
                'label' => array($this, 'block5cc6144d713fa4c2da0011319cebe68b'),
                'placeholder' => array($this, 'block092c73800cd2a09d17d0e686f42bf9ca'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $buffer .= '</div>
';

        return $buffer;
    }

    private function sectionA01094a5d8282b4fc3bb19d463377362(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            searchcourses, block_myoverview
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '
';
                $buffer .= $indent . '            searchcourses, block_myoverview
';
                $buffer .= $indent . '        ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section73a48b054cf23aa2521bfa65793b0052(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            search, core
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '
';
                $buffer .= $indent . '            search, core
';
                $buffer .= $indent . '        ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block5cc6144d713fa4c2da0011319cebe68b($context)
    {
        $indent = $buffer = '';
        $value = $context->find('str');
        $buffer .= $this->sectionA01094a5d8282b4fc3bb19d463377362($context, $indent, $value);
    
        return $buffer;
    }

    public function block092c73800cd2a09d17d0e686f42bf9ca($context)
    {
        $indent = $buffer = '';
        $value = $context->find('str');
        $buffer .= $this->section73a48b054cf23aa2521bfa65793b0052($context, $indent, $value);
    
        return $buffer;
    }
}
