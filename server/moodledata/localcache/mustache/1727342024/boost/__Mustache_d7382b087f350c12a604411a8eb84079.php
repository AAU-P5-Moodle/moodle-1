<?php

class __Mustache_d7382b087f350c12a604411a8eb84079 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div data-region="loading-placeholder-content" aria-hidden="true">
';
        $value = $context->find('card');
        $buffer .= $this->section937084fbbe92b98521b64c50a8ecd2fe($context, $indent, $value);
        $value = $context->find('list');
        $buffer .= $this->sectionE902a55b1fa0c132890494c069398c91($context, $indent, $value);
        $value = $context->find('summary');
        $buffer .= $this->sectionE902a55b1fa0c132890494c069398c91($context, $indent, $value);
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section937084fbbe92b98521b64c50a8ecd2fe(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="card-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 mx-0 flex-nowrap overflow-hidden" style="height: 13rem">
            <div class="col d-flex px-1">{{> core_course/placeholder-course }}</div>
            <div class="col d-flex px-1">{{> core_course/placeholder-course }}</div>
            <div class="col d-flex px-1">{{> core_course/placeholder-course }}</div>
        </div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="card-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 mx-0 flex-nowrap overflow-hidden" style="height: 13rem">
';
                $buffer .= $indent . '            <div class="col d-flex px-1">';
                if ($partial = $this->mustache->loadPartial('core_course/placeholder-course')) {
                    $buffer .= $partial->renderInternal($context);
                }
                $buffer .= '</div>
';
                $buffer .= $indent . '            <div class="col d-flex px-1">';
                if ($partial = $this->mustache->loadPartial('core_course/placeholder-course')) {
                    $buffer .= $partial->renderInternal($context);
                }
                $buffer .= '</div>
';
                $buffer .= $indent . '            <div class="col d-flex px-1">';
                if ($partial = $this->mustache->loadPartial('core_course/placeholder-course')) {
                    $buffer .= $partial->renderInternal($context);
                }
                $buffer .= '</div>
';
                $buffer .= $indent . '        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE902a55b1fa0c132890494c069398c91(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <ul class="list-group">
            {{> block_myoverview/placeholder-course-list-item }}
            {{> block_myoverview/placeholder-course-list-item }}
            {{> block_myoverview/placeholder-course-list-item }}
            {{> block_myoverview/placeholder-course-list-item }}
        </ul>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <ul class="list-group">
';
                if ($partial = $this->mustache->loadPartial('block_myoverview/placeholder-course-list-item')) {
                    $buffer .= $partial->renderInternal($context, $indent . '            ');
                }
                if ($partial = $this->mustache->loadPartial('block_myoverview/placeholder-course-list-item')) {
                    $buffer .= $partial->renderInternal($context, $indent . '            ');
                }
                if ($partial = $this->mustache->loadPartial('block_myoverview/placeholder-course-list-item')) {
                    $buffer .= $partial->renderInternal($context, $indent . '            ');
                }
                if ($partial = $this->mustache->loadPartial('block_myoverview/placeholder-course-list-item')) {
                    $buffer .= $partial->renderInternal($context, $indent . '            ');
                }
                $buffer .= $indent . '        </ul>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
