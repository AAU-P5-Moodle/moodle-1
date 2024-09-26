<?php

class __Mustache_faa399802fe58a4a4a78f8934fbb871b extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $context->find('url');
        $buffer .= $this->sectionCce883c204b2d986cd6cb07d4cf16f62($context, $indent, $value);

        return $buffer;
    }

    private function sectionA966d8bdb8330044e260362d957c7509(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{$ core_courseformat/local/content/cm/cmicon }}
            {{> core_courseformat/local/content/cm/cmicon }}
        {{/ core_courseformat/local/content/cm/cmicon }}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/cm/cmicon');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/cm/cmicon')) {
                        $buffer .= $partial->renderInternal($context, $indent . '            ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3a4fa2b878b80d240439f55ee2eddbc1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    {{$ core/inplace_editable }}
                        {{> core/inplace_editable }}
                    {{/ core/inplace_editable }}
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core/inplace_editable');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core/inplace_editable')) {
                        $buffer .= $partial->renderInternal($context, $indent . '                        ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section39f0904802ec464d5865d217999a7704(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    {{$ core_courseformat/local/content/cm/activitybadge }}
                        {{> core_courseformat/local/content/cm/activitybadge }}
                    {{/ core_courseformat/local/content/cm/activitybadge }}
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/cm/activitybadge');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/cm/activitybadge')) {
                        $buffer .= $partial->renderInternal($context, $indent . '                        ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCce883c204b2d986cd6cb07d4cf16f62(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{! Icon }}
    {{#activityicon}}
        {{$ core_courseformat/local/content/cm/cmicon }}
            {{> core_courseformat/local/content/cm/cmicon }}
        {{/ core_courseformat/local/content/cm/cmicon }}
    {{/activityicon}}

    {{! Name & Badge}}
    <div class="activity-name-area activity-instance d-flex flex-column me-2">
        <div class="activitytitle {{textclasses}} modtype_{{modname}} position-relative align-self-start">
            <div class="activityname">
                {{#activityname}}
                    {{$ core/inplace_editable }}
                        {{> core/inplace_editable }}
                    {{/ core/inplace_editable }}
                {{/activityname}}
                {{#activitybadge}}
                    {{$ core_courseformat/local/content/cm/activitybadge }}
                        {{> core_courseformat/local/content/cm/activitybadge }}
                    {{/ core_courseformat/local/content/cm/activitybadge }}
                {{/activitybadge}}
            </div>
        </div>
    </div>

';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('activityicon');
                $buffer .= $this->sectionA966d8bdb8330044e260362d957c7509($context, $indent, $value);
                $buffer .= $indent . '
';
                $buffer .= $indent . '    <div class="activity-name-area activity-instance d-flex flex-column me-2">
';
                $buffer .= $indent . '        <div class="activitytitle ';
                $value = $this->resolveValue($context->find('textclasses'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ' modtype_';
                $value = $this->resolveValue($context->find('modname'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ' position-relative align-self-start">
';
                $buffer .= $indent . '            <div class="activityname">
';
                $value = $context->find('activityname');
                $buffer .= $this->section3a4fa2b878b80d240439f55ee2eddbc1($context, $indent, $value);
                $value = $context->find('activitybadge');
                $buffer .= $this->section39f0904802ec464d5865d217999a7704($context, $indent, $value);
                $buffer .= $indent . '            </div>
';
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
